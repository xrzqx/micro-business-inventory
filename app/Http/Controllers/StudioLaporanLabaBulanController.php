<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PenjualanProdukBarang;
use Carbon\Carbon;

class StudioLaporanLabaBulanController extends Controller
{
    //
    public function index(){
        $searchYear = Carbon::now()->year;

        $timestampStart = Carbon::createFromFormat('Y-m-d H:i:s', "$searchYear-01-01 00:00:00")->timestamp;
        $timestampEnd = Carbon::createFromFormat('Y-m-d H:i:s', "$searchYear-12-31 23:59:59")->timestamp;

        // Generate a list of all months within the date range
        $allMonths = collect();
        $startDate = Carbon::createFromTimestamp($timestampStart)->startOfMonth();
        $endDate = Carbon::createFromTimestamp($timestampEnd)->endOfMonth();

        while ($startDate->lessThanOrEqualTo($endDate)) {
            $allMonths->push([
                'year' => $startDate->year,
                'month' => $startDate->month,
            ]);
            $startDate->addMonth();
        }

        // $penjualan_laba = $allMonths->map(function ($month) {
        //     return Penjualan::select(
        //             'transaksi_penjualan.transaksi_pembelian_id',
        //             \DB::raw('IFNULL(SUM(transaksi_penjualan.jumlah), 0) as total_jumlah'),
        //             \DB::raw('IFNULL(SUM(transaksi_penjualan.harga), 0) as total_harga')
        //         )
        //         ->join('transaksi_pembelian', 'transaksi_pembelian.id', '=', 'transaksi_penjualan.transaksi_pembelian_id')
        //         ->join('master_item', 'master_item.id', '=', 'transaksi_pembelian.master_item_id')
        //         ->join('kategori', 'kategori.id', '=', 'master_item.kategori_id')
        //         ->where('kategori.toko', '=', 'SGH_Motor')
        //         ->whereYear(\DB::raw('FROM_UNIXTIME(transaksi_penjualan.tanggal)'), $month['year'])
        //         ->whereMonth(\DB::raw('FROM_UNIXTIME(transaksi_penjualan.tanggal)'), $month['month'])
        //         // ->groupBy('year', 'month')
        //         ->groupBy('transaksi_penjualan.transaksi_pembelian_id')
        //         ->with(['pembelian' => function ($query) {
        //             $query->with(['barang' => function ($query) {
        //                 $query->with(['item','kategori']);
        //             }]);
        //         }])
        //         ->get();
        // });

        $penjualan_laba = $allMonths->map(function ($month) {
            return PenjualanProdukBarang::select('penjualan_produk_transaksi_pembelian.*')
                ->join('transaksi_pembelian', 'transaksi_pembelian.id', '=', 'penjualan_produk_transaksi_pembelian.transaksi_pembelian_id')
                ->join('master_item', 'master_item.id', '=', 'transaksi_pembelian.master_item_id')
                ->join('kategori', 'kategori.id', '=', 'master_item.kategori_id')
                ->join('penjualan_produk', 'penjualan_produk.id', '=', 'penjualan_produk_transaksi_pembelian.penjualan_produk_id')
                ->join('produk', 'produk.id', '=', 'penjualan_produk.produk_id')
                ->where('kategori.toko', '=', 'SGH_Studio')
                ->where('produk.toko', '=', 'SGH_Studio')
                ->whereYear(\DB::raw('FROM_UNIXTIME(penjualan_produk.tanggal)'), $month['year'])
                ->whereMonth(\DB::raw('FROM_UNIXTIME(penjualan_produk.tanggal)'), $month['month'])
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
        });

        // return $penjualan_laba;

        $monthNumber  = 1;
        $laba_bulan = [];
        foreach ($penjualan_laba as $innerArray) {
            // $totalLaba = 0;
            // echo $cc;
            $monthName = Carbon::create()->month($monthNumber)->monthName;
            $laba_bulan[$monthName] = 0;
            if (count($innerArray) !== 0) {
                foreach ($innerArray as $value) {
                    $total_hb = ($value->pembelian->harga / $value->pembelian->jumlah) * $value->jumlah;
                    $laba_bulan[$monthName] += $value->penjualan_produk->harga - $total_hb;
                }
            }
            $monthNumber ++;
        }

        $namaArray = [];
        $jumlahArray = [];

        foreach ($laba_bulan as $key => $value) {
            $namaArray[] = $key;
            $jumlahArray[] = $value;
        }

        $data = [
            "labels" => $namaArray,
            "data" => $jumlahArray,
        ];

        return view("studio.laporanlababulan",
        [
            "tahunStart" => $searchYear,
            "data" => $data,
        ]);
    }

    public function search(Request $request)
    {
        $searchYear = $request->input('year');

        if (!$searchYear) {
            $searchYear = Carbon::now()->year;
        }

        // Calculate start and end timestamps for the given year
        $timestampStart = Carbon::createFromFormat('Y-m-d H:i:s', "$searchYear-01-01 00:00:00")->timestamp;
        $timestampEnd = Carbon::createFromFormat('Y-m-d H:i:s', "$searchYear-12-31 23:59:59")->timestamp;

        // Generate a list of all months within the date range
        $allMonths = collect();
        $startDate = Carbon::createFromTimestamp($timestampStart)->startOfMonth();
        $endDate = Carbon::createFromTimestamp($timestampEnd)->endOfMonth();

        $data = [];
        return view("studio.laporanlababulan", 
        [
            "tahunStart" => $searchYear,
            "data" => $data,
        ]);
    }
}
