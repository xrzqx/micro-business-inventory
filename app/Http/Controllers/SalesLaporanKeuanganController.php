<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Sales;
use App\Models\Kategori;
use App\Models\SalesPembelian;
use App\Models\SalesPenjualan;
use Carbon\Carbon;

class SalesLaporanKeuanganController extends Controller
{
    //
    public function index()
    {
        //
        $currentTimestamp = Carbon::now();
        $formattedDate = $currentTimestamp->format('d-m-Y');
        $timestamp = Carbon::parse($formattedDate)->timestamp;
        $salesOpt = Sales::all();
        $kategoriOpt = Kategori::select('kategori.toko')
            ->whereIn('toko', ['rokok', 'minyak', 'beras'])
            ->groupBy('kategori.toko')
            ->get();

        $sales_selected = [];
        $kategori_selected = [];

        $query_sales = [];
        $query_kategori = ['rokok', 'minyak', 'beras'];
        foreach ($salesOpt as $key => $value) {
            $query_sales[] = $value->id;
        }

        // $pembelian = SalesPembelian::select('sales_pembelian.transaksi_pembelian_id', \DB::raw('SUM(sales_pembelian.harga) as total_harga'))
        //     ->join('transaksi_pembelian', 'transaksi_pembelian.id', '=', 'sales_pembelian.transaksi_pembelian_id')
        //     ->join('master_item', 'master_item.id', '=', 'transaksi_pembelian.master_item_id')
        //     ->join('kategori', 'kategori.id', '=', 'master_item.kategori_id')
        //     ->join('item', 'item.id', '=', 'master_item.item_id')
        //     ->whereIn('kategori.toko', ['rokok', 'minyak', 'beras'])
        //     // ->where('kategori.toko', '=', 'SGH_Studio')
        //     // ->where('transaksi_pembelian.tanggal', '>=', $timestamp)
        //     // ->where('transaksi_pembelian.tanggal', '<=', $timestamp)
        //     ->groupBy('sales_pembelian.transaksi_pembelian_id')
        //     ->orderBy('sales_pembelian.tanggal', 'desc')
        //     // ->with(['barang' => function ($query) {
        //     //     $query->with('item');
        //     // }])
        //     ->get();

        $pembelian = SalesPembelian::select('sales_pembelian.sales_id','sales_pembelian.transaksi_pembelian_id', \DB::raw('SUM(sales_pembelian.harga) as total_harga'), \DB::raw('SUM(sales_pembelian.jumlah) as total_barang'))
            ->join('transaksi_pembelian', 'transaksi_pembelian.id', '=', 'sales_pembelian.transaksi_pembelian_id')
            ->join('master_item', 'master_item.id', '=', 'transaksi_pembelian.master_item_id')
            ->join('kategori', 'kategori.id', '=', 'master_item.kategori_id')
            ->join('item', 'item.id', '=', 'master_item.item_id')
            ->where('sales_pembelian.tanggal', '>=', $timestamp)
            ->where('sales_pembelian.tanggal', '<=', $timestamp)
            ->whereIn('kategori.toko', $query_kategori)
            ->whereIn('sales_pembelian.sales_id', $query_sales)
            ->groupBy('sales_pembelian.sales_id', 'sales_pembelian.transaksi_pembelian_id')
            ->orderBy('sales_pembelian.tanggal', 'desc')
            ->with(['pembelian.barang.item', 'sales'])
            ->get();

        $penjualan = SalesPenjualan::select('sales_penjualan.sales_pembelian_id', \DB::raw('SUM(sales_penjualan.jumlah) as total_barang'), \DB::raw('SUM(sales_penjualan.harga) as total_harga'))
            ->join('sales_pembelian', 'sales_pembelian.id', '=', 'sales_penjualan.sales_pembelian_id')
            ->join('transaksi_pembelian', 'transaksi_pembelian.id', '=', 'sales_pembelian.transaksi_pembelian_id')
            ->join('master_item', 'master_item.id', '=', 'transaksi_pembelian.master_item_id')
            ->join('kategori', 'kategori.id', '=', 'master_item.kategori_id')
            ->join('item', 'item.id', '=', 'master_item.item_id')
            ->where('sales_penjualan.tanggal', '>=', $timestamp)
            ->where('sales_penjualan.tanggal', '<=', $timestamp)
            ->whereIn('kategori.toko', $query_kategori)
            ->whereIn('sales_pembelian.sales_id', $query_sales)
            ->groupBy('sales_pembelian_id')
            ->orderBy('sales_penjualan.tanggal', 'desc')
            ->with(['sales_pembelian' => function ($query) {
                $query->with('sales');
                $query->with(['pembelian' => function ($query) {
                    $query->with(['barang' => function ($query) {
                        $query->with('item');
                    }]);
                }]);
            }])
            ->get();

        $data = array_merge($pembelian->toArray(), $penjualan->toArray());
        $associativeArray = array_values($data);
        

        return view("sales.keuangan", 
        [
            "tanggalStart" => $formattedDate,
            "tanggalEnd" => $formattedDate,
            "sales" => $salesOpt,
            "kategori" => $kategoriOpt,
            "sales_selected" => $sales_selected,
            "kategori_selected" => $kategori_selected,
            "data" => $associativeArray,
        ]);
    }

    public function search(Request $request)
    {

        $salesOpt = Sales::all();
        // return $salesOpt;
        $kategoriOpt = Kategori::select('kategori.toko')
            ->whereIn('toko', ['rokok', 'minyak', 'beras'])
            ->groupBy('kategori.toko')
            ->get();

        // return $kategoriOpt;

        $searchStart = $request->input('start');
        $searchEnd = $request->input('end');
        if (!$searchEnd) {
            # code...
            $currentTimestamp = Carbon::now();
            $searchEnd = $currentTimestamp->format('d-m-Y');
        }
        $timestampStart = Carbon::parse($searchStart)->timestamp;
        $timestampEnd = Carbon::parse($searchEnd)->timestamp;

        $sales_selected = $request->input('sales', []);
        $kategori_selected = $request->input('kategori', []);
        // return $sales;

        $pembelian = SalesPembelian::select('sales_pembelian.sales_id','sales_pembelian.transaksi_pembelian_id', \DB::raw('SUM(sales_pembelian.harga) as total_harga'), \DB::raw('SUM(sales_pembelian.jumlah) as total_barang'))
            ->join('transaksi_pembelian', 'transaksi_pembelian.id', '=', 'sales_pembelian.transaksi_pembelian_id')
            ->join('master_item', 'master_item.id', '=', 'transaksi_pembelian.master_item_id')
            ->join('kategori', 'kategori.id', '=', 'master_item.kategori_id')
            ->join('item', 'item.id', '=', 'master_item.item_id')
            ->where('sales_pembelian.tanggal', '>=', $timestampStart)
            ->where('sales_pembelian.tanggal', '<=', $timestampEnd)
            ->whereIn('kategori.toko', $kategori_selected)
            ->whereIn('sales_pembelian.sales_id', $sales_selected)
            ->groupBy('sales_pembelian.sales_id', 'sales_pembelian.transaksi_pembelian_id')
            ->orderBy('sales_pembelian.tanggal', 'desc')
            ->with(['pembelian.barang.item', 'sales'])
            ->get();

        $penjualan = SalesPenjualan::select('sales_penjualan.sales_pembelian_id', \DB::raw('SUM(sales_penjualan.jumlah) as total_barang'), \DB::raw('SUM(sales_penjualan.harga) as total_harga'))
            ->join('sales_pembelian', 'sales_pembelian.id', '=', 'sales_penjualan.sales_pembelian_id')
            ->join('transaksi_pembelian', 'transaksi_pembelian.id', '=', 'sales_pembelian.transaksi_pembelian_id')
            ->join('master_item', 'master_item.id', '=', 'transaksi_pembelian.master_item_id')
            ->join('kategori', 'kategori.id', '=', 'master_item.kategori_id')
            ->join('item', 'item.id', '=', 'master_item.item_id')
            ->where('sales_penjualan.tanggal', '>=', $timestampStart)
            ->where('sales_penjualan.tanggal', '<=', $timestampEnd)
            ->whereIn('kategori.toko', $kategori_selected)
            ->whereIn('sales_pembelian.sales_id', $sales_selected)
            ->groupBy('sales_pembelian_id')
            ->orderBy('sales_penjualan.tanggal', 'desc')
            ->with(['sales_pembelian' => function ($query) {
                $query->with('sales');
                $query->with(['pembelian' => function ($query) {
                    $query->with(['barang' => function ($query) {
                        $query->with('item');
                    }]);
                }]);
            }])
            ->get();

        $data = array_merge($pembelian->toArray(), $penjualan->toArray());
        $associativeArray = array_values($data);
        // return $associativeArray;

        return view("sales.keuangan", 
        [
            "tanggalStart" => $searchStart,
            "tanggalEnd" => $searchEnd,
            "sales" => $salesOpt,
            "kategori" => $kategoriOpt,
            "sales_selected" => $sales_selected,
            "kategori_selected" => $kategori_selected,
            "data" => $associativeArray,
        ]);
        
    }
}
