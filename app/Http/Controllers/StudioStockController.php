<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pembelian;
use App\Models\Barang;
use App\Models\PenjualanProdukBarang;
use App\Models\Limbah;
use Illuminate\Database\Eloquent\Builder;
use Carbon\Carbon;

class StudioStockController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $currentTimestamp = time();
        $formattedDate = date('d-m-Y', $currentTimestamp);
        $timestamp = strtotime($formattedDate);

        $barang = Pembelian::select('transaksi_pembelian.*')
            ->join('master_item', 'master_item.id', '=', 'transaksi_pembelian.master_item_id')
            ->join('kategori', 'kategori.id', '=', 'master_item.kategori_id')
            ->join('item', 'item.id', '=', 'master_item.item_id')
            ->where('kategori.toko', '=', 'SGH_Studio')
            ->where('sisa', '>', 0)
            ->with(['barang' => function ($query) {
                $query->with('item', 'kategori');
            }])
            ->get();
    
        // Group by master_item_id using PHP Collection
        $groupedBarang = $barang->groupBy('master_item_id');
        
        // Convert back to array
        $groupedBarangArray = $groupedBarang->map(function ($items) {
            return $items->toArray();
        })->values()->all();

        $stockdata = []; 

        foreach ($groupedBarangArray as $masterItemId => $items) {
            // echo "Master Item ID: $masterItemId\n";

            $namaBarang = '';
            $stockItem = 0;
        
            foreach ($items as $item) {
                $namaBarang = $item['barang']['item']['nama'];
                $stockItem = $stockItem + $item['sisa'];
                // echo "Transaction ID: {$item['id']}, Nama: {$item['barang']['item']['nama']}, Jumlah: {$item['jumlah']}, Sisa: {$item['sisa']}\n";
            }
            // Key-value pair to append
            $newKeyValuePair = [
                "nama" => $namaBarang,
                "stock" => $stockItem,
                // Other key-value pairs...
            ];
            $stockdata [] = $newKeyValuePair;
            // echo '<br>';
        }

        $pemakaian = PenjualanProdukBarang::select('penjualan_produk_transaksi_pembelian.*')
            ->join('transaksi_pembelian', 'transaksi_pembelian.id', '=', 'penjualan_produk_transaksi_pembelian.transaksi_pembelian_id')
            ->join('penjualan_produk', 'penjualan_produk.id', '=', 'penjualan_produk_transaksi_pembelian.penjualan_produk_id')
            ->join('master_item', 'master_item.id', '=', 'transaksi_pembelian.master_item_id')
            ->join('kategori', 'kategori.id', '=', 'master_item.kategori_id')
            ->where('kategori.toko', '=', 'SGH_Studio')
            ->where('penjualan_produk.tanggal', '=', $timestamp)
            ->with(['pembelian' => function ($query) {
                $query->with(['barang' => function ($query){
                    $query->with('item');
                }]);
            }])
            ->get();

        $barang = Barang::with('item', 'kategori')
            ->whereHas('kategori', function (Builder $query) {
                $query->where('toko', '=', 'SGH_Studio');
            })
            ->get();
        
        $barangArray = [];
        $masukBarangArray = [];

        foreach ($barang as $key => $value) {
            $barangArray[$value->item->nama] = 0;
            $masukBarangArray[$value->item->nama] = 0;
        }

        foreach ($pemakaian as $key => $value) {
            if (isset($barangArray[$value->pembelian->barang->item->nama])) {
                $barangArray[$value->pembelian->barang->item->nama] = $barangArray[$value->pembelian->barang->item->nama] + $value->jumlah;
            }
        }

        $limbah = Limbah::select('limbah.*')
            ->join('transaksi_pembelian', 'transaksi_pembelian.id', '=', 'limbah.transaksi_pembelian_id')
            ->join('master_item', 'master_item.id', '=', 'transaksi_pembelian.master_item_id')
            ->join('kategori', 'kategori.id', '=', 'master_item.kategori_id')
            ->where('kategori.toko', '=', 'SGH_Studio')
            ->where('limbah.tanggal', '=', $timestamp)
            ->with(['pembelian' => function ($query) {
                $query->with(['barang' => function ($query){
                    $query->with('item');
                }]);
            }])
            ->get();

        foreach ($limbah as $key => $value) {
            if (isset($barangArray[$value->pembelian->barang->item->nama])) {
                $barangArray[$value->pembelian->barang->item->nama] = $barangArray[$value->pembelian->barang->item->nama] + $value->jumlah;
            }
        }

        $stockMasukToday = Pembelian::select('transaksi_pembelian.*')
            ->join('master_item', 'master_item.id', '=', 'transaksi_pembelian.master_item_id')
            ->join('kategori', 'kategori.id', '=', 'master_item.kategori_id')
            ->where('kategori.toko', '=', 'SGH_Studio')
            ->where('sisa', '>', 0)
            ->where('transaksi_pembelian.tanggal', '=', $timestamp)
            ->with(['barang' => function ($query) {
                $query->with('item', 'kategori');
            }])
            ->get();

        foreach ($stockMasukToday as $key => $value) {
            if (isset($masukBarangArray[$value->barang->item->nama])) {
                $masukBarangArray[$value->barang->item->nama] = $masukBarangArray[$value->barang->item->nama] + $value->jumlah;
            }
        }

        $newStockData = [];

        foreach ($stockdata as $value) {
            if (isset($barangArray[$value['nama']])) {
                $newKeyValuePair = [
                    "nama" => $value["nama"],
                    "stock" => $value["stock"],
                    "masuk" => $masukBarangArray[$value['nama']],
                    "pemakaian" => $barangArray[$value['nama']]
                ];
                $newStockData [] = $newKeyValuePair;
            }
        }

        // return $newStockData;
        $formattedDate = date('m/d/Y', $currentTimestamp);

        return view("studio.laporanstock", 
        [
            "date" => $formattedDate,
            "data" => $newStockData,

        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
    
    public function search(Request $request)
    {
                // $currentTimestamp = time();
        // $formattedDate = date('d-m-Y', $currentTimestamp);
        // $timestamp = strtotime($formattedDate);

        $searchQuery = $request->input('tanggal');

        $timestamp = strtotime($searchQuery);
        // return $timestamp;

        $barang = Pembelian::select('transaksi_pembelian.*')
            ->join('master_item', 'master_item.id', '=', 'transaksi_pembelian.master_item_id')
            ->join('kategori', 'kategori.id', '=', 'master_item.kategori_id')
            ->join('item', 'item.id', '=', 'master_item.item_id')
            ->where('kategori.toko', '=', 'SGH_Studio')
            ->where('sisa', '>', 0)
            ->with(['barang' => function ($query) {
                $query->with('item', 'kategori');
            }])
            ->get();
    
        // Group by master_item_id using PHP Collection
        $groupedBarang = $barang->groupBy('master_item_id');
        
        // Convert back to array
        $groupedBarangArray = $groupedBarang->map(function ($items) {
            return $items->toArray();
        })->values()->all();

        $stockdata = []; 

        foreach ($groupedBarangArray as $masterItemId => $items) {
            // echo "Master Item ID: $masterItemId\n";

            $namaBarang = '';
            $stockItem = 0;
        
            foreach ($items as $item) {
                $namaBarang = $item['barang']['item']['nama'];
                $stockItem = $stockItem + $item['sisa'];
                // echo "Transaction ID: {$item['id']}, Nama: {$item['barang']['item']['nama']}, Jumlah: {$item['jumlah']}, Sisa: {$item['sisa']}\n";
            }
            // Key-value pair to append
            $newKeyValuePair = [
                "nama" => $namaBarang,
                "stock" => $stockItem,
                // Other key-value pairs...
            ];
            $stockdata [] = $newKeyValuePair;
            // echo '<br>';
        }

        $pemakaian = PenjualanProdukBarang::select('penjualan_produk_transaksi_pembelian.*')
            ->join('transaksi_pembelian', 'transaksi_pembelian.id', '=', 'penjualan_produk_transaksi_pembelian.transaksi_pembelian_id')
            ->join('penjualan_produk', 'penjualan_produk.id', '=', 'penjualan_produk_transaksi_pembelian.penjualan_produk_id')
            ->join('master_item', 'master_item.id', '=', 'transaksi_pembelian.master_item_id')
            ->join('kategori', 'kategori.id', '=', 'master_item.kategori_id')
            ->where('kategori.toko', '=', 'SGH_Studio')
            ->where('penjualan_produk.tanggal', '=', $timestamp)
            ->with(['pembelian' => function ($query) {
                $query->with(['barang' => function ($query){
                    $query->with('item');
                }]);
            }])
            ->get();

        $barang = Barang::with('item', 'kategori')
            ->whereHas('kategori', function (Builder $query) {
                $query->where('toko', '=', 'SGH_Studio');
            })
            ->get();
        
        $barangArray = [];
        $masukBarangArray = [];

        foreach ($barang as $key => $value) {
            $barangArray[$value->item->nama] = 0;
            $masukBarangArray[$value->item->nama] = 0;
        }

        foreach ($pemakaian as $key => $value) {
            if (isset($barangArray[$value->pembelian->barang->item->nama])) {
                $barangArray[$value->pembelian->barang->item->nama] = $barangArray[$value->pembelian->barang->item->nama] + $value->jumlah;
            }
        }

        $limbah = Limbah::select('limbah.*')
            ->join('transaksi_pembelian', 'transaksi_pembelian.id', '=', 'limbah.transaksi_pembelian_id')
            ->join('master_item', 'master_item.id', '=', 'transaksi_pembelian.master_item_id')
            ->join('kategori', 'kategori.id', '=', 'master_item.kategori_id')
            ->where('kategori.toko', '=', 'SGH_Studio')
            ->where('limbah.tanggal', '=', $timestamp)
            ->with(['pembelian' => function ($query) {
                $query->with(['barang' => function ($query){
                    $query->with('item');
                }]);
            }])
            ->get();

        foreach ($limbah as $key => $value) {
            if (isset($barangArray[$value->pembelian->barang->item->nama])) {
                $barangArray[$value->pembelian->barang->item->nama] = $barangArray[$value->pembelian->barang->item->nama] + $value->jumlah;
            }
        }

        $stockMasukToday = Pembelian::select('transaksi_pembelian.*')
            ->join('master_item', 'master_item.id', '=', 'transaksi_pembelian.master_item_id')
            ->join('kategori', 'kategori.id', '=', 'master_item.kategori_id')
            ->where('kategori.toko', '=', 'SGH_Studio')
            ->where('sisa', '>', 0)
            ->where('transaksi_pembelian.tanggal', '=', $timestamp)
            ->with(['barang' => function ($query) {
                $query->with('item', 'kategori');
            }])
            ->get();

        foreach ($stockMasukToday as $key => $value) {
            if (isset($masukBarangArray[$value->barang->item->nama])) {
                $masukBarangArray[$value->barang->item->nama] = $masukBarangArray[$value->barang->item->nama] + $value->jumlah;
            }
        }

        $newStockData = [];

        foreach ($stockdata as $value) {
            if (isset($barangArray[$value['nama']])) {
                $newKeyValuePair = [
                    "nama" => $value["nama"],
                    "stock" => $value["stock"],
                    "masuk" => $masukBarangArray[$value['nama']],
                    "pemakaian" => $barangArray[$value['nama']]
                ];
                $newStockData [] = $newKeyValuePair;
            }
        }

        // return $newStockData;
        // $formattedDate = date('d-m-Y', $timestamp);

        return view("studio.laporanstock", 
        [
            // "date" => $formattedDate,
            "data" => $newStockData,
        ]);
    }
}
