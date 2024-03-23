<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Penjualan;
use App\Models\Kategori;
use Carbon\Carbon;
use App\Utils\ColorUtils;

class MotorLaporanMovingStock extends Controller
{
    //
    public function index()
    {
        // Initialize an empty array to store "nama" values
        $namaArray = [];
        $data = [];
        $kategori_selected = [];
        $kategoriOpt = Kategori::select('kategori.nama')
            ->where('toko', 'SGH_Motor')
            ->get();
        // return $kategoriOpt;

        $currentTimestamp = Carbon::now();
        $formattedDate = $currentTimestamp->format('d-m-Y');
        $timestamp = Carbon::parse($formattedDate)->timestamp;

        $penjualan = Penjualan::select('transaksi_penjualan.transaksi_pembelian_id', \DB::raw('SUM(transaksi_penjualan.jumlah) as total_jumlah'))
            ->join('transaksi_pembelian', 'transaksi_pembelian.id', '=', 'transaksi_penjualan.transaksi_pembelian_id')
            ->join('customer', 'customer.id', '=', 'transaksi_penjualan.customer_id')
            ->join('master_item', 'master_item.id', '=', 'transaksi_pembelian.master_item_id')
            ->join('kategori', 'kategori.id', '=', 'master_item.kategori_id')
            ->where('kategori.toko', '=', 'SGH_Motor')
            ->where('customer.module', '=', 'SGH_Motor')
            ->where('transaksi_penjualan.tanggal', '>=', $timestamp)
            ->where('transaksi_penjualan.tanggal', '<=', $timestamp)
            ->groupBy('transaksi_penjualan.transaksi_pembelian_id','transaksi_pembelian.master_item_id')
            ->orderBy(\DB::raw('SUM(transaksi_penjualan.jumlah)'), 'desc')
            ->with(['pembelian' => function ($query) {
                $query->with(['barang' => function ($query) {
                    $query->with(['item', 'kategori']);
                }]);
            }])
            ->get();

        foreach ($penjualan as $value) {
            $namaArray[] = $value->pembelian->barang->item->nama;
            $data[] = $value->total_jumlah;
        }

        $data = [
            'labels' => $namaArray,
            'data' => $data,
        ];

        return view("motor.laporanmovingstock", 
        [
            "kategori" => $kategoriOpt,
            "kategori_selected" => $kategori_selected,
            "tanggalStart" => $formattedDate,
            "tanggalEnd" => $formattedDate,
            "data" => $data,
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
        $timestampStart = Carbon::parse($searchStart)->timestamp;
        $timestampEnd = Carbon::parse($searchEnd)->timestamp;

        $kategori_selected = $request->input('kategori', []);
        // return $kategori_selected;

        $penjualan = Penjualan::select('transaksi_penjualan.transaksi_pembelian_id', \DB::raw('SUM(transaksi_penjualan.jumlah) as total_jumlah'))
            ->join('transaksi_pembelian', 'transaksi_pembelian.id', '=', 'transaksi_penjualan.transaksi_pembelian_id')
            ->join('customer', 'customer.id', '=', 'transaksi_penjualan.customer_id')
            ->join('master_item', 'master_item.id', '=', 'transaksi_pembelian.master_item_id')
            ->join('kategori', 'kategori.id', '=', 'master_item.kategori_id')
            ->where('kategori.toko', '=', 'SGH_Motor')
            ->where('transaksi_penjualan.tanggal', '>=', $timestampStart)
            ->where('transaksi_penjualan.tanggal', '<=', $timestampEnd)
            ->whereIn('kategori.nama', $kategori_selected)
            ->groupBy('transaksi_penjualan.transaksi_pembelian_id','transaksi_pembelian.master_item_id')
            ->orderBy(\DB::raw('SUM(transaksi_penjualan.jumlah)'), 'desc')
            ->with(['pembelian' => function ($query) {
                $query->with(['barang' => function ($query) {
                    $query->with(['item', 'kategori']);
                }]);
            }])
            ->get();

        // return $penjualan;

        $kategoriOpt = Kategori::select('kategori.nama')
            ->where('toko', 'SGH_Motor')
            ->get();

        $namaArray = [];
        $jumlahArray = [];

        foreach ($penjualan as $value) {
            $namaArray[] = $value->pembelian->barang->item->nama;
            $jumlahArray[] = $value->total_jumlah;
        }

        $data = [
            "labels" => $namaArray,
            "data" => $jumlahArray,
        ];

        return view("motor.laporanmovingstock", 
        [
            "kategori" => $kategoriOpt,
            "kategori_selected" => $kategori_selected,
            "tanggalStart" => $searchStart,
            "tanggalEnd" => $searchEnd,
            "data" => $data,
        ]);

    }
}
