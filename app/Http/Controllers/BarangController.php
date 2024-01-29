<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SalesPembelian;

class BarangController extends Controller
{
    //
    public function fetchData(Request $request)
    {
        $salesId = $request->get('salesId');

        // $barangData = SalesPembelian::with(['pembelian' => function ($query) {
        //     $query->with(['barang' => function ($query) {
        //         $query->with('item');
        //     }]);
        // }])
        // ->get();

        // Fetch data based on the selected category (adjust the logic based on your requirements)
        // $batchData = BatchProduk::where('category_id', $categoryId)->get();
        $barangData = SalesPembelian::select(['master_item.id', 'item.nama'])
        // $barangData = SalesPembelian::select('master_item.id')
            ->join('transaksi_pembelian', 'transaksi_pembelian.id', '=', 'sales_pembelian.transaksi_pembelian_id')
            ->join('master_item', 'master_item.id', '=', 'transaksi_pembelian.master_item_id')
            ->join('kategori', 'kategori.id', '=', 'master_item.kategori_id')
            ->join('item', 'item.id', '=', 'master_item.item_id')
            ->where('sales_pembelian.sales_id', '=', $salesId)
            ->where('sales_pembelian.sisa', '>', 0)
            ->distinct('item.id')
            ->get();

        return response()->json($barangData);
    }
}
