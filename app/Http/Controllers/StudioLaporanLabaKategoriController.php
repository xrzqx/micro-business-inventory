<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PenjualanProdukBarang;
use Carbon\Carbon;

class StudioLaporanLabaKategoriController extends Controller
{
    //
    public function index(){
        $data = [];

        $currentTimestamp = Carbon::now();
        $formattedDate = $currentTimestamp->format('d-m-Y');
        $timestamp = Carbon::parse($formattedDate)->timestamp;

        $penjualan_laba = PenjualanProdukBarang::select('penjualan_produk_transaksi_pembelian.*')
            ->join('transaksi_pembelian', 'transaksi_pembelian.id', '=', 'penjualan_produk_transaksi_pembelian.transaksi_pembelian_id')
            ->join('master_item', 'master_item.id', '=', 'transaksi_pembelian.master_item_id')
            ->join('kategori', 'kategori.id', '=', 'master_item.kategori_id')
            ->join('penjualan_produk', 'penjualan_produk.id', '=', 'penjualan_produk_transaksi_pembelian.penjualan_produk_id')
            ->join('produk', 'produk.id', '=', 'penjualan_produk.produk_id')
            ->where('kategori.toko', '=', 'SGH_Studio')
            ->where('produk.toko', '=', 'SGH_Studio')
            ->where('penjualan_produk.tanggal', '>=', $timestamp)
            ->where('penjualan_produk.tanggal', '<=', $timestamp)
            ->orderBy('penjualan_produk.tanggal', 'desc')
            ->with(['penjualan_produk' => function ($query) {
                $query->with(['produk' => function ($query) {
                }]);
            }])
            ->with(['pembelian' => function ($query) {
                $query->with(['barang' => function ($query) {
                    $query->with(['item','kategori']);
                }]);
            }])
            ->get();

        $totalLaba = 0;
        $laba_kategori = [];
        foreach ($penjualan_laba as $value) {
            $total_hb = ($value->pembelian->harga / $value->pembelian->jumlah) * $value->jumlah;
            $totalLaba += $value->penjualan_produk->harga - $total_hb;
            if (!isset($laba_kategori[$value->penjualan_produk->produk->nama])) {
                $laba_kategori[$value->penjualan_produk->produk->nama] = 0;
            }
            $laba_kategori[$value->penjualan_produk->produk->nama] += $value->penjualan_produk->harga - $total_hb;
        }

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

        return view("studio.laporanlaba", 
        [
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

        $penjualan_laba = PenjualanProdukBarang::select('penjualan_produk_transaksi_pembelian.*')
            ->join('transaksi_pembelian', 'transaksi_pembelian.id', '=', 'penjualan_produk_transaksi_pembelian.transaksi_pembelian_id')
            ->join('master_item', 'master_item.id', '=', 'transaksi_pembelian.master_item_id')
            ->join('kategori', 'kategori.id', '=', 'master_item.kategori_id')
            ->join('penjualan_produk', 'penjualan_produk.id', '=', 'penjualan_produk_transaksi_pembelian.penjualan_produk_id')
            ->join('produk', 'produk.id', '=', 'penjualan_produk.produk_id')
            ->where('kategori.toko', '=', 'SGH_Studio')
            ->where('produk.toko', '=', 'SGH_Studio')
            ->where('penjualan_produk.tanggal', '>=', $timestampStart)
            ->where('penjualan_produk.tanggal', '<=', $timestampEnd)
            ->orderBy('penjualan_produk.tanggal', 'desc')
            ->with(['penjualan_produk' => function ($query) {
                $query->with(['produk' => function ($query) {
                }]);
            }])
            ->with(['pembelian' => function ($query) {
                $query->with(['barang' => function ($query) {
                    $query->with(['item','kategori']);
                }]);
            }])
            ->get();

        $totalLaba = 0;
        $laba_kategori = [];
        foreach ($penjualan_laba as $value) {
            $total_hb = ($value->pembelian->harga / $value->pembelian->jumlah) * $value->jumlah;
            $totalLaba += $value->penjualan_produk->harga - $total_hb;
            if (!isset($laba_kategori[$value->penjualan_produk->produk->nama])) {
                $laba_kategori[$value->penjualan_produk->produk->nama] = 0;
            }
            $laba_kategori[$value->penjualan_produk->produk->nama] += $value->penjualan_produk->harga - $total_hb;
        }

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
        return view("studio.laporanlaba", 
        [
            "tanggalStart" => $searchStart,
            "tanggalEnd" => $searchEnd,
            "data" => $data,
        ]);
    }
}
