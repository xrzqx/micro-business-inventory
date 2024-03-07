<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pembelian;
use App\Models\PenjualanProdukBarang;
use App\Models\PenjualanProduk;
use App\Models\Pengeluaran;
use Carbon\Carbon;

class StudioLaporanKeuanganController extends Controller
{
    //
    public function index()
    {
        //
        $currentTimestamp = Carbon::now();
        $formattedDate = $currentTimestamp->format('d-m-Y');
        $timestamp = Carbon::parse($formattedDate)->timestamp;

        $pembelian = Pembelian::select('transaksi_pembelian.master_item_id', \DB::raw('SUM(harga) as total_harga'))
            ->join('master_item', 'master_item.id', '=', 'transaksi_pembelian.master_item_id')
            ->join('kategori', 'kategori.id', '=', 'master_item.kategori_id')
            ->join('item', 'item.id', '=', 'master_item.item_id')
            ->where('kategori.toko', '=', 'SGH_Studio')
            ->where('transaksi_pembelian.tanggal', '>=', $timestamp)
            ->where('transaksi_pembelian.tanggal', '<=', $timestamp)
            ->groupBy('transaksi_pembelian.master_item_id')
            ->orderBy('transaksi_pembelian.tanggal', 'desc')
            ->with(['barang' => function ($query) {
                $query->with('item');
            }])
            ->get();

        $penjualan = PenjualanProduk::select('produk_id', \DB::raw('SUM(harga) as total_harga'))
            ->where('tanggal', '>=', $timestamp)
            ->where('tanggal', '<=', $timestamp)
            ->groupBy('produk_id')
            ->orderBy('tanggal', 'desc')
            ->with(['produk']) // Assuming you have a relationship named 'produk' in your PenjualanProduk model
            ->get();

        $pengeluaran = Pengeluaran::select('pengeluaran.*')
            ->where('toko', 'studio')
            ->where('pengeluaran.tanggal', '>=', $timestamp)
            ->where('pengeluaran.tanggal', '<=', $timestamp)
            ->orderBy('pengeluaran.tanggal', 'desc')
            ->get();

        // Append results to $data array
        $data = array_merge($pembelian->toArray(), $penjualan->toArray(), $pengeluaran->toArray());

        // Convert back to an associative array with numeric keys
        $associativeArray = array_values($data);

        return view("studio.keuangan", 
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

        if (!$searchEnd) {
            # code...
            $currentTimestamp = Carbon::now();
            $searchEnd = $currentTimestamp->format('d-m-Y');
        }

        // Convert the selected date to a timestamp (UNIX timestamp)
        $timestampStart = Carbon::parse($searchStart)->timestamp;
        $timestampEnd = Carbon::parse($searchEnd)->timestamp;
        
        $pembelian = Pembelian::select('transaksi_pembelian.master_item_id', \DB::raw('SUM(harga) as total_harga'))
            ->join('master_item', 'master_item.id', '=', 'transaksi_pembelian.master_item_id')
            ->join('kategori', 'kategori.id', '=', 'master_item.kategori_id')
            ->join('item', 'item.id', '=', 'master_item.item_id')
            ->where('kategori.toko', '=', 'SGH_Studio')
            ->where('transaksi_pembelian.tanggal', '>=', $timestampStart)
            ->where('transaksi_pembelian.tanggal', '<=', $timestampEnd)
            ->groupBy('transaksi_pembelian.master_item_id')
            ->orderBy('transaksi_pembelian.tanggal', 'desc')
            ->with(['barang' => function ($query) {
                $query->with('item');
            }])
            ->get();

        $penjualan = PenjualanProduk::select('produk_id', \DB::raw('SUM(harga) as total_harga'))
            ->where('tanggal', '>=', $timestampStart)
            ->where('tanggal', '<=', $timestampEnd)
            ->groupBy('produk_id')
            ->orderBy('tanggal', 'desc')
            ->with(['produk']) // Assuming you have a relationship named 'produk' in your PenjualanProduk model
            ->get();

        $pengeluaran = Pengeluaran::select('pengeluaran.*')
            ->where('toko', 'studio')
            ->where('pengeluaran.tanggal', '>=', $timestampStart)
            ->where('pengeluaran.tanggal', '<=', $timestampEnd)
            ->orderBy('pengeluaran.tanggal', 'desc')
            ->get();

        $data = array_merge($pembelian->toArray(), $penjualan->toArray(), $pengeluaran->toArray());

        // Convert back to an associative array with numeric keys
        $associativeArray = array_values($data);

        return view("studio.keuangan", 
        [
            "tanggalStart" => $searchStart,
            "tanggalEnd" => $searchEnd,
            "data" => $associativeArray,
        ]);
    }
}
