<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Penjualan;
use Carbon\Carbon;

class PupukLaporanPenjualanController extends Controller
{
    //
    public function index(){
        $currentTimestamp = Carbon::now();
        $formattedDate = $currentTimestamp->format('d-m-Y');
        $timestamp = Carbon::parse($formattedDate)->timestamp;

        $penjualan = Penjualan::select('transaksi_penjualan.transaksi_pembelian_id', \DB::raw('SUM(transaksi_penjualan.jumlah) as total_jumlah'), \DB::raw('SUM(transaksi_penjualan.harga) as total_harga'))
            ->join('transaksi_pembelian', 'transaksi_pembelian.id', '=', 'transaksi_penjualan.transaksi_pembelian_id')
            ->join('master_item', 'master_item.id', '=', 'transaksi_pembelian.master_item_id')
            ->join('kategori', 'kategori.id', '=', 'master_item.kategori_id')
            ->where('kategori.toko', '=', 'pupuk')
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
            ->paginate(8);
        
            // return $penjualan;

        $penjualan_laba = Penjualan::select('transaksi_penjualan.transaksi_pembelian_id', \DB::raw('SUM(transaksi_penjualan.jumlah) as total_jumlah'), \DB::raw('SUM(transaksi_penjualan.harga) as total_harga'))
            ->join('transaksi_pembelian', 'transaksi_pembelian.id', '=', 'transaksi_penjualan.transaksi_pembelian_id')
            ->join('master_item', 'master_item.id', '=', 'transaksi_pembelian.master_item_id')
            ->join('kategori', 'kategori.id', '=', 'master_item.kategori_id')
            ->where('kategori.toko', '=', 'pupuk')
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
            ->paginate(8);

        $totalLaba = 0;
        foreach ($penjualan_laba as $value) {
            $total_hb = ($value->pembelian->harga / $value->pembelian->jumlah) * $value->total_jumlah;
            $totalLaba += $value->total_harga - $total_hb;
        }

        return view("pupuk.laporanpenjualan", 
        [
            "tanggalStart" => $formattedDate,
            "tanggalEnd" => $formattedDate,
            "data" => $penjualan,
            "totalLaba" => $totalLaba,
        ]);
    }

    public function search(Request $request)
    {
        $searchStart = $request->input('start');
        $searchEnd = $request->input('end');
        if (!$searchEnd) {
            # code...
            $currentTimestamp = Carbon::now();
            $searchEnd = $currentTimestamp->format('d-m-Y');
        }

        // Convert the selected date to a timestamp (UNIX timestamp)
        $timestampStart = Carbon::parse($searchStart)->timestamp;
        $timestampEnd = Carbon::parse($searchEnd)->timestamp;
        
        $penjualan = Penjualan::select('transaksi_penjualan.transaksi_pembelian_id', \DB::raw('SUM(transaksi_penjualan.jumlah) as total_jumlah'), \DB::raw('SUM(transaksi_penjualan.harga) as total_harga'))
            ->join('transaksi_pembelian', 'transaksi_pembelian.id', '=', 'transaksi_penjualan.transaksi_pembelian_id')
            ->join('master_item', 'master_item.id', '=', 'transaksi_pembelian.master_item_id')
            ->join('kategori', 'kategori.id', '=', 'master_item.kategori_id')
            ->where('kategori.toko', '=', 'pupuk')
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
            ->paginate(8);

        $penjualan_laba = Penjualan::select('transaksi_penjualan.transaksi_pembelian_id', \DB::raw('SUM(transaksi_penjualan.jumlah) as total_jumlah'), \DB::raw('SUM(transaksi_penjualan.harga) as total_harga'))
            ->join('transaksi_pembelian', 'transaksi_pembelian.id', '=', 'transaksi_penjualan.transaksi_pembelian_id')
            ->join('master_item', 'master_item.id', '=', 'transaksi_pembelian.master_item_id')
            ->join('kategori', 'kategori.id', '=', 'master_item.kategori_id')
            ->where('kategori.toko', '=', 'pupuk')
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

        $totalLaba = 0;
        foreach ($penjualan_laba as $value) {
            $total_hb = ($value->pembelian->harga / $value->pembelian->jumlah) * $value->total_jumlah;
            $totalLaba += $value->total_harga - $total_hb;
        }

        return view("pupuk.laporanpenjualan", 
        [
            "tanggalStart" => $searchStart,
            "tanggalEnd" => $searchEnd,
            "data" => $penjualan,
            "totalLaba" => $totalLaba,
        ]);
    }
}
