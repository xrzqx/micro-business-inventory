<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Penjualan;
use App\Models\Kategori;
use Carbon\Carbon;

class MotorLaporanLabaKategoriController extends Controller
{
    //
    public function index(){
        $namaArray = [];
        $data = [];
        // $kategori_selected = [];
        // $kategoriOpt = Kategori::select('kategori.nama')
        //     ->where('toko', 'SGH_Motor')
        //     ->get();

        $currentTimestamp = Carbon::now();
        $formattedDate = $currentTimestamp->format('d-m-Y');
        $timestamp = Carbon::parse($formattedDate)->timestamp;

        $penjualan_laba = Penjualan::select('transaksi_penjualan.transaksi_pembelian_id', \DB::raw('SUM(transaksi_penjualan.jumlah) as total_jumlah'), \DB::raw('SUM(transaksi_penjualan.harga) as total_harga'))
            ->join('transaksi_pembelian', 'transaksi_pembelian.id', '=', 'transaksi_penjualan.transaksi_pembelian_id')
            ->join('master_item', 'master_item.id', '=', 'transaksi_pembelian.master_item_id')
            ->join('kategori', 'kategori.id', '=', 'master_item.kategori_id')
            ->where('kategori.toko', '=', 'SGH_Motor')
            ->where('transaksi_penjualan.tanggal', '>=', $timestamp)
            ->where('transaksi_penjualan.tanggal', '<=', $timestamp)
            ->groupBy('transaksi_penjualan.transaksi_pembelian_id')
            ->orderBy('transaksi_penjualan.tanggal', 'desc')
            ->with(['pembelian' => function ($query) {
                $query->with(['barang' => function ($query) {
                    $query->with(['item','kategori']);
                }]);
            }])
            ->orderBy('transaksi_penjualan.tanggal', 'desc')
            ->get();

        $totalLaba = 0;
        $laba_kategori = [];
        foreach ($penjualan_laba as $value) {
            $total_hb = ($value->pembelian->harga / $value->pembelian->jumlah) * $value->total_jumlah;
            $totalLaba += $value->total_harga - $total_hb;
            if (!isset($laba_kategori[$value->pembelian->barang->kategori->nama])) {
                $laba_kategori[$value->pembelian->barang->kategori->nama] = 0;
            }
            $laba_kategori[$value->pembelian->barang->kategori->nama] += $value->total_harga - $total_hb;
        }

        $namaArray = [];
        $jumlahArray = [];

        foreach ($laba_kategori as $key => $value) {
            $namaArray[] = $key;
            $jumlahArray[] = $value;
        }

        $data = [
            'labels' => $namaArray,
            'data' => $data,
        ];
        return view("motor.laporanlaba",
        [
            // "kategori" => $kategoriOpt,
            // "kategori_selected" => $kategori_selected,
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
            $currentTimestamp = Carbon::now();
            $searchEnd = $currentTimestamp->format('d-m-Y');
        }
        $timestampStart = Carbon::parse($searchStart)->timestamp;
        $timestampEnd = Carbon::parse($searchEnd)->timestamp;

        // $kategori_selected = $request->input('kategori', []);

        $penjualan_laba = Penjualan::select('transaksi_penjualan.transaksi_pembelian_id', \DB::raw('SUM(transaksi_penjualan.jumlah) as total_jumlah'), \DB::raw('SUM(transaksi_penjualan.harga) as total_harga'))
            ->join('transaksi_pembelian', 'transaksi_pembelian.id', '=', 'transaksi_penjualan.transaksi_pembelian_id')
            ->join('master_item', 'master_item.id', '=', 'transaksi_pembelian.master_item_id')
            ->join('kategori', 'kategori.id', '=', 'master_item.kategori_id')
            ->where('kategori.toko', '=', 'SGH_Motor')
            ->where('transaksi_penjualan.tanggal', '>=', $timestampStart)
            ->where('transaksi_penjualan.tanggal', '<=', $timestampEnd)
            ->groupBy('transaksi_penjualan.transaksi_pembelian_id')
            ->orderBy('transaksi_penjualan.tanggal', 'desc')
            ->with(['pembelian' => function ($query) {
                $query->with(['barang' => function ($query) {
                    $query->with(['item','kategori']);
                }]);
            }])
            ->orderBy('transaksi_penjualan.tanggal', 'desc')
            ->get();

        $totalLaba = 0;
        $laba_kategori = [];
        foreach ($penjualan_laba as $value) {
            $total_hb = ($value->pembelian->harga / $value->pembelian->jumlah) * $value->total_jumlah;
            $totalLaba += $value->total_harga - $total_hb;
            if (!isset($laba_kategori[$value->pembelian->barang->kategori->nama])) {
                $laba_kategori[$value->pembelian->barang->kategori->nama] = 0;
            }
            $laba_kategori[$value->pembelian->barang->kategori->nama] += $value->total_harga - $total_hb;
        }

        // return $totalLaba;

        // $kategoriOpt = Kategori::select('kategori.nama')
        //     ->where('toko', 'SGH_Motor')
        //     ->get();

        $namaArray = [];
        $jumlahArray = [];

        foreach ($laba_kategori as $key => $value) {
            $percentage = ($value / $totalLaba) * 100;
            $namaArray[] = $key . " (". round($percentage, 2)."%)";
            $jumlahArray[] = $value;
        }

        $data = [
            "labels" => $namaArray,
            "data" => $jumlahArray,
        ];

        return view("motor.laporanlaba", 
        [
            // "kategori" => $kategoriOpt,
            // "kategori_selected" => $kategori_selected,
            "tanggalStart" => $searchStart,
            "tanggalEnd" => $searchEnd,
            "data" => $data,
        ]);
    }
}
