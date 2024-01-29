<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SalesPembelian;

class BatchSalesController extends Controller
{
    //
    public function fetchData(Request $request)
    {
        $masterItemId = $request->get('masterItemId');
        $salesId = $request->get('salesId');

        $batchData = SalesPembelian::select(['sales_pembelian.id', 'transaksi_pembelian.batch', 'sales_pembelian.sisa'])
        // $barangData = SalesPembelian::select('master_item.id')
            ->join('transaksi_pembelian', 'transaksi_pembelian.id', '=', 'sales_pembelian.transaksi_pembelian_id')
            ->join('master_item', 'master_item.id', '=', 'transaksi_pembelian.master_item_id')
            ->join('kategori', 'kategori.id', '=', 'master_item.kategori_id')
            ->join('item', 'item.id', '=', 'master_item.item_id')
            ->where('sales_pembelian.sales_id', '=', $salesId)
            ->where('sales_pembelian.sisa', '>', 0)
            ->where('transaksi_pembelian.master_item_id', '=', $masterItemId)
            ->distinct('item.id')
            ->get();

        return response()->json($batchData);
    }
}
