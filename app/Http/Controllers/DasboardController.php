<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pembelian;
use App\Models\Penjualan;
use App\Models\PenjualanProduk;
use App\Models\PenjualanProdukBarang;
use App\Models\SalesPenjualan;
use App\Models\Brilink;
use App\Models\Pinjaman;
use App\Models\Pengeluaran;
use App\Models\Beban;
use Carbon\Carbon;
use App\Utils\TimeIntervalUtils;

class DasboardController extends Controller
{
    //
    public function index(){
        $timestampMinTx = Penjualan::select(\DB::raw('min(transaksi_penjualan.tanggal) as tanggal'))->first();
        $timestampMinStudioTx = PenjualanProduk::select(\DB::raw('min(penjualan_produk.tanggal) as tanggal'))->first();
        $timestampMinPinjamanTx = Pinjaman::select(\DB::raw('min(pinjaman.tanggal) as tanggal'))->first();
        $timestampMinPembelianTx = Pembelian::select(\DB::raw('min(transaksi_pembelian.tanggal) as tanggal'))->first();
        // return $timestampMinPinjamanTx;
        $minValueTimestamp = min($timestampMinTx->tanggal, $timestampMinStudioTx->tanggal, $timestampMinPinjamanTx->tanggal, $timestampMinPembelianTx->tanggal);


        $timestampStart = $minValueTimestamp; // Assuming start timestamp is 2021-01-01
        $timestampEnd = time(); // Assuming end timestamp is now

        // return $timestampEnd;

        $timeIntervalUtils = new TimeIntervalUtils();
        $time_intervals = $timeIntervalUtils->iterate_time_intervals($timestampStart, $timestampEnd);
        // return $time_intervals;

        $penjualan_laba_studio = collect();
        foreach ($time_intervals as $value) {
            $res = PenjualanProdukBarang::select('penjualan_produk_transaksi_pembelian.*')
            ->join('transaksi_pembelian', 'transaksi_pembelian.id', '=', 'penjualan_produk_transaksi_pembelian.transaksi_pembelian_id')
            ->join('master_item', 'master_item.id', '=', 'transaksi_pembelian.master_item_id')
            ->join('kategori', 'kategori.id', '=', 'master_item.kategori_id')
            ->join('penjualan_produk', 'penjualan_produk.id', '=', 'penjualan_produk_transaksi_pembelian.penjualan_produk_id')
            ->join('produk', 'produk.id', '=', 'penjualan_produk.produk_id')
            ->where('kategori.toko', '=', 'SGH_Studio')
            ->where('produk.toko', '=', 'SGH_Studio')
            ->where('penjualan_produk.tanggal', '>=', $value['start'])
            ->where('penjualan_produk.tanggal', '<=', $value['end'])
            ->orderBy('penjualan_produk.tanggal', 'desc')
            ->with(['penjualan_produk' => function ($query) {
                $query->with(['produk' => function ($query) {
                }]);
            }])
            ->with(['pembelian' => function ($query) {
                $query->with(['barang' => function ($query) {
                    $query->with(['item','kategori']);
                }]);
            }])
            ->get();
            $penjualan_laba_studio->push($res);
        }

        // $laba_kotor[] = 0;
        $laba_kotor_nama = ["today","yesterday","last7days","last30days","last60days","last90days","alltime"];
        $laba_kotor_studio = [];
        $idx = 0;
        foreach ($penjualan_laba_studio as $innerArray) {
            $laba_kotor_studio[$laba_kotor_nama[$idx]] = 0;
            if (count($innerArray) !== 0) {
                foreach ($innerArray as $value) {
                    $total_hb = ($value->pembelian->harga / $value->pembelian->jumlah) * $value->jumlah;
                    $laba_kotor_studio[$laba_kotor_nama[$idx]] += $value->penjualan_produk->harga - $total_hb;
                }
            }
            $idx ++;
        }
        // return $laba_kotor_studio;

        $penjualan_laba_sparepart = collect();
        foreach ($time_intervals as $value) {
            $res = Penjualan::select('transaksi_penjualan.transaksi_pembelian_id', \DB::raw('SUM(transaksi_penjualan.jumlah) as total_jumlah'),\DB::raw('SUM(transaksi_penjualan.harga) as total_harga'))
            ->join('transaksi_pembelian', 'transaksi_pembelian.id', '=', 'transaksi_penjualan.transaksi_pembelian_id')
            ->join('master_item', 'master_item.id', '=', 'transaksi_pembelian.master_item_id')
            ->join('kategori', 'kategori.id', '=', 'master_item.kategori_id')
            ->where('kategori.toko', '=', 'SGH_Motor')
            ->where('transaksi_penjualan.tanggal', '>=', $value['start'])
            ->where('transaksi_penjualan.tanggal', '<=', $value['end'])
            ->groupBy('transaksi_penjualan.transaksi_pembelian_id')
            ->orderBy('transaksi_penjualan.tanggal', 'desc')
            ->with(['pembelian' => function ($query) {
                $query->with(['barang' => function ($query) {
                    $query->with('item');
                }]);
            }])
            ->get();
            $penjualan_laba_sparepart->push($res);
        }

        $laba_kotor_sparepart = [];
        $idx = 0;
        foreach ($penjualan_laba_sparepart as $innerArray) {
            $laba_kotor_sparepart[$laba_kotor_nama[$idx]] = 0;
            if (count($innerArray) !== 0) {
                foreach ($innerArray as $value) {
                    $hargabeli = ($value->pembelian->harga / $value->pembelian->jumlah) * $value->total_jumlah;
                    $laba_kotor_sparepart[$laba_kotor_nama[$idx]] += $value->total_harga - $hargabeli;
                }
            }
            $idx ++;
        }

        // return $laba_kotor_sparepart;

        $penjualan_laba_rokok = collect();
        foreach ($time_intervals as $value) {
            $res = Penjualan::select('transaksi_penjualan.transaksi_pembelian_id', \DB::raw('SUM(transaksi_penjualan.jumlah) as total_jumlah'),\DB::raw('SUM(transaksi_penjualan.harga) as total_harga'))
            ->join('transaksi_pembelian', 'transaksi_pembelian.id', '=', 'transaksi_penjualan.transaksi_pembelian_id')
            ->join('master_item', 'master_item.id', '=', 'transaksi_pembelian.master_item_id')
            ->join('kategori', 'kategori.id', '=', 'master_item.kategori_id')
            ->where('kategori.toko', '=', 'rokok')
            ->where('transaksi_penjualan.tanggal', '>=', $value['start'])
            ->where('transaksi_penjualan.tanggal', '<=', $value['end'])
            ->groupBy('transaksi_penjualan.transaksi_pembelian_id')
            ->orderBy('transaksi_penjualan.tanggal', 'desc')
            ->with(['pembelian' => function ($query) {
                $query->with(['barang' => function ($query) {
                    $query->with('item');
                }]);
            }])
            ->get();
            $penjualan_laba_rokok->push($res);
        }
        // return $penjualan_laba_rokok;
        $laba_kotor_rokok = [];
        $idx = 0;
        foreach ($penjualan_laba_rokok as $innerArray) {
            $laba_kotor_rokok[$laba_kotor_nama[$idx]] = 0;
            if (count($innerArray) !== 0) {
                foreach ($innerArray as $value) {
                    $hargabeli = ($value->pembelian->harga / $value->pembelian->jumlah) * $value->total_jumlah;
                    $laba_kotor_rokok[$laba_kotor_nama[$idx]] += $value->total_harga - $hargabeli;
                }
            }
            $idx ++;
        }

        // return $laba_kotor_rokok;
        
        $penjualan_sales_laba_rokok = collect();
        foreach ($time_intervals as $value) {
            $res = SalesPenjualan::select('sales_penjualan.sales_pembelian_id', \DB::raw('SUM(sales_penjualan.jumlah) as total_jumlah'),\DB::raw('SUM(sales_penjualan.harga) as total_harga'))
            ->join('sales_pembelian', 'sales_pembelian.id', '=', 'sales_penjualan.sales_pembelian_id')
            ->join('transaksi_pembelian', 'transaksi_pembelian.id', '=', 'sales_pembelian.transaksi_pembelian_id')
            ->join('master_item', 'master_item.id', '=', 'transaksi_pembelian.master_item_id')
            ->join('kategori', 'kategori.id', '=', 'master_item.kategori_id')
            ->where('kategori.toko', '=', 'rokok')
            ->where('sales_penjualan.tanggal', '>=', $value['start'])
            ->where('sales_penjualan.tanggal', '<=', $value['end'])
            ->groupBy('sales_penjualan.sales_pembelian_id')
            ->orderBy('sales_penjualan.tanggal', 'desc')
            ->with(['sales_pembelian' => function ($query) {
                $query->with(['pembelian' => function ($query) {
                    $query->with(['barang' => function ($query) {
                        $query->with('item');
                    }]);
                }]);
            }])
            ->get();
            $penjualan_sales_laba_rokok->push($res);
        }

        // return $penjualan_sales_laba_rokok;
        // return $laba_kotor_rokok;

        $idx = 0;
        foreach ($penjualan_sales_laba_rokok as $innerArray) {
            if (count($innerArray) !== 0) {
                foreach ($innerArray as $value) {
                    $hargabeli = ($value->sales_pembelian->pembelian->harga / $value->sales_pembelian->pembelian->jumlah) * $value->total_jumlah;
                    $laba_kotor_rokok[$laba_kotor_nama[$idx]] += $value->total_harga - $hargabeli;
                }
            }
            $idx ++;
        }

        $penjualan_laba_minyak = collect();
        foreach ($time_intervals as $value) {
            $res = Penjualan::select('transaksi_penjualan.transaksi_pembelian_id', \DB::raw('SUM(transaksi_penjualan.jumlah) as total_jumlah'),\DB::raw('SUM(transaksi_penjualan.harga) as total_harga'))
            ->join('transaksi_pembelian', 'transaksi_pembelian.id', '=', 'transaksi_penjualan.transaksi_pembelian_id')
            ->join('master_item', 'master_item.id', '=', 'transaksi_pembelian.master_item_id')
            ->join('kategori', 'kategori.id', '=', 'master_item.kategori_id')
            ->where('kategori.toko', '=', 'minyak')
            ->where('transaksi_penjualan.tanggal', '>=', $value['start'])
            ->where('transaksi_penjualan.tanggal', '<=', $value['end'])
            ->groupBy('transaksi_penjualan.transaksi_pembelian_id')
            ->orderBy('transaksi_penjualan.tanggal', 'desc')
            ->with(['pembelian' => function ($query) {
                $query->with(['barang' => function ($query) {
                    $query->with('item');
                }]);
            }])
            ->get();
            $penjualan_laba_minyak->push($res);
        }

        // return $penjualan_laba_minyak;

        $laba_kotor_minyak = [];
        $idx = 0;
        foreach ($penjualan_laba_minyak as $innerArray) {
            $laba_kotor_minyak[$laba_kotor_nama[$idx]] = 0;
            if (count($innerArray) !== 0) {
                foreach ($innerArray as $value) {
                    $hargabeli = ($value->pembelian->harga / $value->pembelian->jumlah) * $value->total_jumlah;
                    $laba_kotor_minyak[$laba_kotor_nama[$idx]] += $value->total_harga - $hargabeli;
                }
            }
            $idx ++;
        }

        // return $laba_kotor_minyak;

        $penjualan_sales_laba_minyak = collect();
        foreach ($time_intervals as $value) {
            $res = SalesPenjualan::select('sales_penjualan.sales_pembelian_id', \DB::raw('SUM(sales_penjualan.jumlah) as total_jumlah'),\DB::raw('SUM(sales_penjualan.harga) as total_harga'))
            ->join('sales_pembelian', 'sales_pembelian.id', '=', 'sales_penjualan.sales_pembelian_id')
            ->join('transaksi_pembelian', 'transaksi_pembelian.id', '=', 'sales_pembelian.transaksi_pembelian_id')
            ->join('master_item', 'master_item.id', '=', 'transaksi_pembelian.master_item_id')
            ->join('kategori', 'kategori.id', '=', 'master_item.kategori_id')
            ->where('kategori.toko', '=', 'minyak')
            ->where('sales_penjualan.tanggal', '>=', $value['start'])
            ->where('sales_penjualan.tanggal', '<=', $value['end'])
            ->groupBy('sales_penjualan.sales_pembelian_id')
            ->orderBy('sales_penjualan.tanggal', 'desc')
            ->with(['sales_pembelian' => function ($query) {
                $query->with(['pembelian' => function ($query) {
                    $query->with(['barang' => function ($query) {
                        $query->with('item');
                    }]);
                }]);
            }])
            ->get();
            $penjualan_sales_laba_minyak->push($res);
        }

        $idx = 0;
        foreach ($penjualan_sales_laba_minyak as $innerArray) {
            if (count($innerArray) !== 0) {
                foreach ($innerArray as $value) {
                    $hargabeli = ($value->sales_pembelian->pembelian->harga / $value->sales_pembelian->pembelian->jumlah) * $value->total_jumlah;
                    $laba_kotor_minyak[$laba_kotor_nama[$idx]] += $value->total_harga - $hargabeli;
                }
            }
            $idx ++;
        }

        // return $laba_kotor_minyak;

        $penjualan_laba_beras = collect();
        foreach ($time_intervals as $value) {
            $res = Penjualan::select('transaksi_penjualan.transaksi_pembelian_id', \DB::raw('SUM(transaksi_penjualan.jumlah) as total_jumlah'),\DB::raw('SUM(transaksi_penjualan.harga) as total_harga'))
            ->join('transaksi_pembelian', 'transaksi_pembelian.id', '=', 'transaksi_penjualan.transaksi_pembelian_id')
            ->join('master_item', 'master_item.id', '=', 'transaksi_pembelian.master_item_id')
            ->join('kategori', 'kategori.id', '=', 'master_item.kategori_id')
            ->where('kategori.toko', '=', 'beras')
            ->where('transaksi_penjualan.tanggal', '>=', $value['start'])
            ->where('transaksi_penjualan.tanggal', '<=', $value['end'])
            ->groupBy('transaksi_penjualan.transaksi_pembelian_id')
            ->orderBy('transaksi_penjualan.tanggal', 'desc')
            ->with(['pembelian' => function ($query) {
                $query->with(['barang' => function ($query) {
                    $query->with('item');
                }]);
            }])
            ->get();
            $penjualan_laba_beras->push($res);
        }

        $laba_kotor_beras = [];
        $idx = 0;
        foreach ($penjualan_laba_beras as $innerArray) {
            $laba_kotor_beras[$laba_kotor_nama[$idx]] = 0;
            if (count($innerArray) !== 0) {
                foreach ($innerArray as $value) {
                    $hargabeli = ($value->pembelian->harga / $value->pembelian->jumlah) * $value->total_jumlah;
                    $laba_kotor_beras[$laba_kotor_nama[$idx]] += $value->total_harga - $hargabeli;
                }
            }
            $idx ++;
        }

        $penjualan_sales_laba_beras = collect();
        foreach ($time_intervals as $value) {
            $res = SalesPenjualan::select('sales_penjualan.sales_pembelian_id', \DB::raw('SUM(sales_penjualan.jumlah) as total_jumlah'),\DB::raw('SUM(sales_penjualan.harga) as total_harga'))
            ->join('sales_pembelian', 'sales_pembelian.id', '=', 'sales_penjualan.sales_pembelian_id')
            ->join('transaksi_pembelian', 'transaksi_pembelian.id', '=', 'sales_pembelian.transaksi_pembelian_id')
            ->join('master_item', 'master_item.id', '=', 'transaksi_pembelian.master_item_id')
            ->join('kategori', 'kategori.id', '=', 'master_item.kategori_id')
            ->where('kategori.toko', '=', 'minyak')
            ->where('sales_penjualan.tanggal', '>=', $value['start'])
            ->where('sales_penjualan.tanggal', '<=', $value['end'])
            ->groupBy('sales_penjualan.sales_pembelian_id')
            ->orderBy('sales_penjualan.tanggal', 'desc')
            ->with(['sales_pembelian' => function ($query) {
                $query->with(['pembelian' => function ($query) {
                    $query->with(['barang' => function ($query) {
                        $query->with('item');
                    }]);
                }]);
            }])
            ->get();
            $penjualan_sales_laba_beras->push($res);
        }

        $idx = 0;
        foreach ($penjualan_sales_laba_beras as $innerArray) {
            if (count($innerArray) !== 0) {
                foreach ($innerArray as $value) {
                    $hargabeli = ($value->sales_pembelian->pembelian->harga / $value->sales_pembelian->pembelian->jumlah) * $value->total_jumlah;
                    $laba_kotor_beras[$laba_kotor_nama[$idx]] += $value->total_harga - $hargabeli;
                }
            }
            $idx ++;
        }

        // return $laba_kotor_beras;

        $penjualan_laba_brilink = collect();
        foreach ($time_intervals as $value) {
            $res = Brilink::select('brilink.admin')
            ->where('brilink.tanggal', '>=', $value['start'])
            ->where('brilink.tanggal', '<=', $value['end'])
            ->orderBy('brilink.tanggal', 'desc')
            ->get();
            $penjualan_laba_brilink->push($res);
        }

        // return $penjualan_laba_brilink;

        $laba_kotor_brilink = [];
        $idx = 0;
        foreach ($penjualan_laba_brilink as $innerArray) {
            $laba_kotor_brilink[$laba_kotor_nama[$idx]] = 0;
            if (count($innerArray) !== 0) {
                foreach ($innerArray as $value) {
                    $laba_kotor_brilink[$laba_kotor_nama[$idx]] += $value->admin;
                }
            }
            $idx ++;
        }

        // return $laba_kotor_brilink;

        $penjualan_laba_pupuk = collect();
        foreach ($time_intervals as $value) {
            $res = Penjualan::select('transaksi_penjualan.transaksi_pembelian_id', \DB::raw('SUM(transaksi_penjualan.jumlah) as total_jumlah'),\DB::raw('SUM(transaksi_penjualan.harga) as total_harga'))
            ->join('transaksi_pembelian', 'transaksi_pembelian.id', '=', 'transaksi_penjualan.transaksi_pembelian_id')
            ->join('master_item', 'master_item.id', '=', 'transaksi_pembelian.master_item_id')
            ->join('kategori', 'kategori.id', '=', 'master_item.kategori_id')
            ->where('kategori.toko', '=', 'pupuk')
            ->where('transaksi_penjualan.tanggal', '>=', $value['start'])
            ->where('transaksi_penjualan.tanggal', '<=', $value['end'])
            ->groupBy('transaksi_penjualan.transaksi_pembelian_id')
            ->orderBy('transaksi_penjualan.tanggal', 'desc')
            ->with(['pembelian' => function ($query) {
                $query->with(['barang' => function ($query) {
                    $query->with('item');
                }]);
            }])
            ->get();
            $penjualan_laba_pupuk->push($res);
        }

        $laba_kotor_pupuk = [];
        $idx = 0;
        foreach ($penjualan_laba_pupuk as $innerArray) {
            $laba_kotor_pupuk[$laba_kotor_nama[$idx]] = 0;
            if (count($innerArray) !== 0) {
                foreach ($innerArray as $value) {
                    $hargabeli = ($value->pembelian->harga / $value->pembelian->jumlah) * $value->total_jumlah;
                    $laba_kotor_pupuk[$laba_kotor_nama[$idx]] += $value->total_harga - $hargabeli;
                }
            }
            $idx ++;
        }

        $data_laba_kotor = [];

        $idx = 0;
        foreach ($time_intervals as $value) {
            $data_laba_kotor[$laba_kotor_nama[$idx]] = 0;
            $data_laba_kotor[$laba_kotor_nama[$idx]] = $laba_kotor_studio[$laba_kotor_nama[$idx]] + $laba_kotor_sparepart[$laba_kotor_nama[$idx]] + $laba_kotor_rokok[$laba_kotor_nama[$idx]] +
                $laba_kotor_minyak[$laba_kotor_nama[$idx]] + $laba_kotor_beras[$laba_kotor_nama[$idx]] + $laba_kotor_brilink[$laba_kotor_nama[$idx]] + $laba_kotor_pupuk[$laba_kotor_nama[$idx]];
            $idx ++;
        }

        $pinjaman = collect();
        foreach ($time_intervals as $value) {
            $res = Pinjaman::select('pinjaman.customer_id', \DB::raw('SUM(pinjaman.debit) as total_debit'), \DB::raw('SUM(pinjaman.kredit) as total_kredit'))
            ->join('customer', 'customer.id', '=', 'pinjaman.customer_id')
            ->where('pinjaman.tanggal', '>=', $value['start'])
            ->where('pinjaman.tanggal', '<=', $value['end'])
            ->groupBy('pinjaman.customer_id')
            ->orderBy('pinjaman.tanggal', 'desc')
            ->with('customer')
            ->get();
            $pinjaman->push($res);
        }
        // return $pinjaman;
        $data_pinjaman = [];
        $idx = 0;
        foreach ($pinjaman as $innerArray) {
            $data_pinjaman[$laba_kotor_nama[$idx]] = 0;
            if (count($innerArray) !== 0) {
                foreach ($innerArray as $value) {
                    $data_pinjaman[$laba_kotor_nama[$idx]] += $value->total_kredit - $value->total_debit;
                }
            }
            $idx ++;
        }
        // return $data_pinjaman;
        // return $pinjaman;

        $data_pengeluaran_chart = [];
        $pengeluaran = collect();
        foreach ($time_intervals as $value) {
            $res = Pengeluaran::select('pengeluaran.toko', \DB::raw('SUM(pengeluaran.harga) as total_kredit'))
            // ->join('customer', 'customer.id', '=', 'pinjaman.customer_id')
            ->where('pengeluaran.tanggal', '>=', $value['start'])
            ->where('pengeluaran.tanggal', '<=', $value['end'])
            ->groupBy('pengeluaran.toko')
            ->orderBy('pengeluaran.tanggal', 'desc')
            ->get();
            $pengeluaran->push($res);
        }

        // return $pengeluaran;
        // return $laba_kotor_nama;

        $data_pengeluaran = [];
        $idx = 0;
        foreach ($pengeluaran as $innerArray) {
            $data_pengeluaran[$laba_kotor_nama[$idx]] = 0;
            if (count($innerArray) !== 0) {
                foreach ($innerArray as $value) {
                    if (isset($data_pengeluaran_chart[$value->toko])) {
                        // Key exists in the array
                        $data_pengeluaran_chart[$value->toko] = $value->total_kredit;
                    } else {
                        // Key does not exist in the array
                        $data_pengeluaran_chart[$value->toko] = $value->total_kredit;
                    }
                    $data_pengeluaran[$laba_kotor_nama[$idx]] += $value->total_kredit;
                }
            }
            $idx ++;
        }

        // return $data_pengeluaran;

        $beban = collect();
        foreach ($time_intervals as $value) {
            $res = Beban::select(\DB::raw('SUM(beban.harga) as total_kredit'))
            ->where('beban.tanggal', '>=', $value['start'])
            ->where('beban.tanggal', '<=', $value['end'])
            ->get();
            $beban->push($res);
        }

        $idx = 0;
        foreach ($beban as $innerArray) {
            // $data_pengeluaran[$laba_kotor_nama[$idx]] = 0;
            foreach ($innerArray as $value) {
                $data_pengeluaran[$laba_kotor_nama[$idx]] += $value["total_kredit"];
            }
            $idx ++;
        }
        
        $pembelian = collect();
        foreach ($time_intervals as $value) {
            $res = Pembelian::select('kategori.toko', \DB::raw('SUM(transaksi_pembelian.harga) as total_kredit'))
            // ->join('customer', 'customer.id', '=', 'pinjaman.customer_id')
            ->join('master_item', 'master_item.id', '=', 'transaksi_pembelian.master_item_id')
            ->join('kategori', 'kategori.id', '=', 'master_item.kategori_id')
            ->where('transaksi_pembelian.tanggal', '>=', $value['start'])
            ->where('transaksi_pembelian.tanggal', '<=', $value['end'])
            ->groupBy('kategori.toko')
            ->orderBy('transaksi_pembelian.tanggal', 'desc')
            ->get();
            $pembelian->push($res);
        }

        $data_pembelian = [];
        $data_pembelian_chart = [];
        $data_pembelian_chart_time = [];
        $idx = 0;
        foreach ($pembelian as $innerArray) {
            if (count($innerArray) !== 0) {
                $total = 0;
                foreach ($innerArray as $value) {
                    $total += $value->total_kredit;
                    if (isset($data_pembelian_chart[$value->toko])) {
                        // Key exists in the array
                        $data_pembelian_chart[$value->toko] = $value->total_kredit;
                        $data_pembelian_chart_time[$laba_kotor_nama[$idx]] = $data_pembelian_chart;
                    } 
                    else {
                        // Key does not exist in the array
                        $data_pembelian_chart[$value->toko] = $value->total_kredit;
                        $data_pembelian_chart_time[$laba_kotor_nama[$idx]] = $data_pembelian_chart;
                    }
                }
                $data_pembelian[$laba_kotor_nama[$idx]] = $total;
            }
            else{
                $data_pembelian[$laba_kotor_nama[$idx]] = 0;
            }
            $idx ++;
        }

        $inventory = collect();
        foreach ($time_intervals as $value) {
            $res = Pembelian::select('*')
            ->join('master_item', 'master_item.id', '=', 'transaksi_pembelian.master_item_id')
            ->join('kategori', 'kategori.id', '=', 'master_item.kategori_id')
            ->where('transaksi_pembelian.tanggal', '>=', $value['start'])
            ->where('transaksi_pembelian.tanggal', '<=', $value['end'])
            ->where('sisa','>', '0')
            ->orderBy('transaksi_pembelian.tanggal', 'desc')
            ->get();
            $inventory->push($res);
        }
        // return $inventory;

        $data_inventory = [];
        // $data_inventory_chart = [];
        // $data_inventory_chart_time = [];
        $idx = 0;
        foreach ($inventory as $innerArray) {
            if (count($innerArray) !== 0) {
                // echo $innerArray;
                $total = 0;
                foreach ($innerArray as $value) {
                    // echo $value;
                    $total += ($value->harga/$value->jumlah) * $value->sisa;
                    
                    // $total += $value->total_kredit;
                    // if (isset($data_pembelian_chart[$value->toko])) {
                    //     // Key exists in the array
                    //     $data_pembelian_chart[$value->toko] = $value->total_kredit;
                    //     $data_pembelian_chart_time[$laba_kotor_nama[$idx]] = $data_pembelian_chart;
                    // } 
                    // else {
                    //     // Key does not exist in the array
                    //     $data_pembelian_chart[$value->toko] = $value->total_kredit;
                    //     $data_pembelian_chart_time[$laba_kotor_nama[$idx]] = $data_pembelian_chart;
                    // }
                }
                $data_inventory[$laba_kotor_nama[$idx]] = $total;
            }
            else{
                // echo "xx";
                $data_inventory[$laba_kotor_nama[$idx]] = 0;
            }
            $idx ++;
        }

        $data_laba_bersih = $data_laba_kotor;
        
        $data_laba_bersih['today'] = $data_laba_kotor['today'] - $data_pinjaman['today'] - $data_pengeluaran['today'] - $data_pembelian['today'];
        $data_laba_bersih['yesterday'] = $data_laba_kotor['yesterday'] - $data_pinjaman['yesterday'] - $data_pengeluaran['yesterday'] - $data_pembelian['yesterday'];
        $data_laba_bersih['last7days'] = $data_laba_kotor['last7days'] - $data_pinjaman['last7days'] - $data_pengeluaran['last7days'] - $data_pembelian['last7days'];
        $data_laba_bersih['last30days'] = $data_laba_kotor['last30days'] - $data_pinjaman['last30days'] - $data_pengeluaran['last30days'] - $data_pembelian['last30days'];
        $data_laba_bersih['last60days'] = $data_laba_kotor['last60days'] - $data_pinjaman['last60days'] - $data_pengeluaran['last60days'] - $data_pembelian['last60days'];
        $data_laba_bersih['last90days'] = $data_laba_kotor['last90days'] - $data_pinjaman['last90days'] - $data_pengeluaran['last90days'] - $data_pembelian['last90days'];
        $data_laba_bersih['alltime'] = $data_laba_kotor['alltime'] - $data_pinjaman['alltime'] - $data_pengeluaran['alltime'] - $data_pembelian['alltime'];
        // return $data_laba_bersih;
        // return $data_pembelian_chart_time['alltime']['SGH_Motor'];
        // return $data_pembelian;
        // return $data_pembelian_chart_time;
        
        return view('dashboard.index',[
            'data_laba_kotor' => $data_laba_kotor,
            'data_pinjaman' => $data_pinjaman,
            'data_pengeluaran' => $data_pengeluaran,
            'data_pembelian' => $data_pembelian,
            'data_inventory' => $data_inventory,
            'data_laba_bersih' => $data_laba_bersih,
            'data_pembelian_chart' => $data_pembelian_chart_time,
            'laba_kotor_sparepart' => $laba_kotor_sparepart,
            'laba_kotor_studio' => $laba_kotor_studio,
            'laba_kotor_rokok' => $laba_kotor_rokok,
            'laba_kotor_minyak' => $laba_kotor_minyak,
            'laba_kotor_beras' => $laba_kotor_beras,
            'laba_kotor_brilink' => $laba_kotor_brilink,
            'laba_kotor_pupuk' => $laba_kotor_pupuk,
        ]);
    }
}
