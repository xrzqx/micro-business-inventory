<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pembelian;
use App\Models\Penjualan;
use Carbon\Carbon;

class RokokLaporanKeuanganController extends Controller
{
    //
    public function index(){
        //
        $currentTimestamp = Carbon::now();
        $formattedDate = $currentTimestamp->format('d-m-Y');
        $timestamp = Carbon::parse($formattedDate)->timestamp;

        $pembelian = Pembelian::select('transaksi_pembelian.master_item_id', \DB::raw('SUM(transaksi_pembelian.harga) as total_harga'))
            ->join('master_item', 'master_item.id', '=', 'transaksi_pembelian.master_item_id')
            ->join('kategori', 'kategori.id', '=', 'master_item.kategori_id')
            ->join('item', 'item.id', '=', 'master_item.item_id')
            ->where('kategori.toko', '=', 'rokok')
            ->where('transaksi_pembelian.tanggal', '>=', $timestamp)
            ->where('transaksi_pembelian.tanggal', '<=', $timestamp)
            ->groupBy('transaksi_pembelian.master_item_id')
            ->orderBy('transaksi_pembelian.tanggal', 'desc')
            ->with(['barang' => function ($query) {
                $query->with('item');
            }])
            ->get();

        $penjualan = Penjualan::select('transaksi_penjualan.transaksi_pembelian_id', \DB::raw('SUM(transaksi_penjualan.harga) as total_harga'))
            ->join('transaksi_pembelian', 'transaksi_pembelian.id', '=', 'transaksi_penjualan.transaksi_pembelian_id')
            ->join('master_item', 'master_item.id', '=', 'transaksi_pembelian.master_item_id')
            ->join('kategori', 'kategori.id', '=', 'master_item.kategori_id')
            ->where('kategori.toko', '=', 'rokok')
            ->where('transaksi_penjualan.tanggal', '>=', $timestamp)
            ->where('transaksi_penjualan.tanggal', '<=', $timestamp)
            ->groupBy('transaksi_penjualan.transaksi_pembelian_id')
            ->orderBy('transaksi_penjualan.tanggal', 'desc')
            ->with(['pembelian' => function ($query) {
                $query->with(['barang' => function ($query) {
                    $query->with('item');
                }]);
            }])
            ->orderBy('transaksi_penjualan.tanggal', 'desc')
            ->get();

        $data = array_merge($pembelian->toArray(), $penjualan->toArray());

        $associativeArray = array_values($data);

        // return $pembelian;

        return view("rokok.keuangan", 
        [
            "tanggalStart" => $formattedDate,
            "tanggalEnd" => $formattedDate,
            "data" => $associativeArray,
        ]);
    }

    public function search(Request $request)
    {
        $searchStart = $request->input('start');
        $searchEnd = $request->input('end');

        // Convert the selected date to a timestamp (UNIX timestamp)
        $timestampStart = Carbon::parse($searchStart)->timestamp;
        $timestampEnd = Carbon::parse($searchEnd)->timestamp;
        
        $pembelian = Pembelian::select('transaksi_pembelian.master_item_id', \DB::raw('SUM(transaksi_pembelian.harga) as total_harga'))
            ->join('master_item', 'master_item.id', '=', 'transaksi_pembelian.master_item_id')
            ->join('kategori', 'kategori.id', '=', 'master_item.kategori_id')
            ->join('item', 'item.id', '=', 'master_item.item_id')
            ->where('kategori.toko', '=', 'rokok')
            ->where('transaksi_pembelian.tanggal', '>=', $timestampStart)
            ->where('transaksi_pembelian.tanggal', '<=', $timestampEnd)
            ->groupBy('transaksi_pembelian.master_item_id')
            ->orderBy('transaksi_pembelian.tanggal', 'desc')
            ->with(['barang' => function ($query) {
                $query->with('item');
            }])
            ->get();

        $penjualan = Penjualan::select('transaksi_penjualan.transaksi_pembelian_id', \DB::raw('SUM(transaksi_penjualan.harga) as total_harga'))
            ->join('transaksi_pembelian', 'transaksi_pembelian.id', '=', 'transaksi_penjualan.transaksi_pembelian_id')
            ->join('master_item', 'master_item.id', '=', 'transaksi_pembelian.master_item_id')
            ->join('kategori', 'kategori.id', '=', 'master_item.kategori_id')
            ->where('kategori.toko', '=', 'rokok')
            ->where('transaksi_penjualan.tanggal', '>=', $timestampStart)
            ->where('transaksi_penjualan.tanggal', '<=', $timestampEnd)
            ->groupBy('transaksi_penjualan.transaksi_pembelian_id')
            ->orderBy('transaksi_penjualan.tanggal', 'desc')
            ->with(['pembelian' => function ($query) {
                $query->with(['barang' => function ($query) {
                    $query->with('item');
                }]);
            }])
            ->orderBy('transaksi_penjualan.tanggal', 'desc')
            ->get();

        $data = array_merge($pembelian->toArray(), $penjualan->toArray());

        $associativeArray = array_values($data);

        // return $associativeArray;

        return view("rokok.keuangan", 
        [
            "tanggalStart" => $searchStart,
            "tanggalEnd" => $searchEnd,
            "data" => $associativeArray,
        ]);
    }
}
