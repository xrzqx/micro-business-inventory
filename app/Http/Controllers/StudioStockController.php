<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pembelian;
use App\Models\Barang;
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
        // $stock =
        $mytime = Carbon::now();
        $oneDayAgo = $mytime->subDay();
        // return $oneDayAgo;
        $timestamp = Carbon::parse($oneDayAgo)->timestamp;
        // return $timestamp;

        $barang = Pembelian::select('transaksi_pembelian.*')
            ->join('master_item', 'master_item.id', '=', 'transaksi_pembelian.master_item_id')
            ->join('kategori', 'kategori.id', '=', 'master_item.kategori_id')
            ->join('item', 'item.id', '=', 'master_item.item_id')
            ->where('kategori.toko', '=', 'SGH_Studio')
            ->where('sisa', '>', 0)
            // ->where('transaksi_pembelian.tanggal', '<', $timestamp)
            // ->groupBy('transaksi_pembelian.master_item_id')
            // ->distinct()
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
            // $masterItemId is the unique master_item_id
            // $items is an array containing related transaksi_pembelian records
        
            // Your code here to process each group
            echo "Master Item ID: $masterItemId\n";

            $namaBarang = '';
            $stockItem = 0;
        
            foreach ($items as $item) {
                $namaBarang = $item['barang']['item']['nama'];
                $stockItem = $stockItem + $item['sisa'];
                // $item is an individual transaksi_pembelian record
                // Your code here to process each transaksi_pembelian record
                echo "Transaction ID: {$item['id']}, Nama: {$item['barang']['item']['nama']}, Jumlah: {$item['jumlah']}, Sisa: {$item['sisa']}\n";
            }
            echo 'nama : '. $namaBarang;
            echo 'stock : '.$stockItem;
            // Key-value pair to append
            $newKeyValuePair = [
                "nama" => $namaBarang,
                "stock" => $stockItem,
                // Other key-value pairs...
            ];
            $stockdata [] = $newKeyValuePair;
            echo '<br>';
        }

        $newStockData = [];

        foreach ($stockdata as $key => $value) {
            dd ($value);
            $newKeyValuePair = [
                "nama" => $value["name"],
                "stock" => $value["stock"],
                "masuk" => 0,
            ];
        }

        return 'lol';

        return view("studio.laporanstock", 
        [
            // "barang" => $barang,
            // "pembelian" => $pembelian,
            // "limbah" => $limbah,
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
}
