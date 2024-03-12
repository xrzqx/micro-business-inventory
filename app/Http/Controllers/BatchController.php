<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pembelian;

class BatchController extends Controller
{
    //
    public function fetchData(Request $request)
    {
        $masterItemId = $request->get('masterItemId');

        // Fetch data based on the selected category (adjust the logic based on your requirements)
        // $batchData = BatchProduk::where('category_id', $categoryId)->get();
        $batchData = Pembelian::where('master_item_id', $masterItemId)->where('sisa', '>', 0)->select('id', 'batch', 'jumlah', 'sisa', 'het', 'harga')->get();

        return response()->json($batchData);
    }
    public function fetchEditData(Request $request)
    {
        $masterItemId = $request->get('masterItemId');

        // Fetch data based on the selected category (adjust the logic based on your requirements)
        // $batchData = BatchProduk::where('category_id', $categoryId)->get();
        $batchData = Pembelian::where('master_item_id', $masterItemId)->select('id', 'batch', 'jumlah', 'sisa', 'het', 'harga')->get();

        return response()->json($batchData);
    }
}
