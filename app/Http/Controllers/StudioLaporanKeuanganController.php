<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pembelian;
use App\Models\PenjualanProdukBarang;
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
        
        $pembelian = Pembelian::select('transaksi_pembelian.*')
            ->join('master_item', 'master_item.id', '=', 'transaksi_pembelian.master_item_id')
            ->join('kategori', 'kategori.id', '=', 'master_item.kategori_id')
            ->join('item', 'item.id', '=', 'master_item.item_id')
            ->where('kategori.toko', '=', 'SGH_Studio')
            ->where('transaksi_pembelian.tanggal', '>=', $timestamp)
            ->where('transaksi_pembelian.tanggal', '<=', $timestamp)
            ->orderBy('transaksi_pembelian.tanggal', 'desc')
            ->with(['barang' => function ($query) {
                $query->with('item');
            }])
            // ->paginate(7);
            ->get();

        $penjualan = PenjualanProdukBarang::select('penjualan_produk_transaksi_pembelian.penjualan_produk_id')
            ->join('transaksi_pembelian', 'transaksi_pembelian.id', '=', 'penjualan_produk_transaksi_pembelian.transaksi_pembelian_id')
            ->join('penjualan_produk', 'penjualan_produk.id', '=', 'penjualan_produk_transaksi_pembelian.penjualan_produk_id')
            ->where('penjualan_produk.tanggal', '>=', $timestamp)
            ->where('penjualan_produk.tanggal', '<=', $timestamp)
            ->groupBy('penjualan_produk_transaksi_pembelian.penjualan_produk_id')
            ->orderBy('penjualan_produk.tanggal', 'desc')
            ->with(['penjualan_produk' => function ($query) {
                $query->with('produk');
            }])
            ->get();

        // Append results to $data array
        $data = array_merge($pembelian->toArray(), $penjualan->toArray());

        // Sort $data array by 'tanggal' field
        usort($data, function ($a, $b) {
            $timeA = Carbon::parse($a['tanggal'])->timestamp;
            $timeB = Carbon::parse($b['tanggal'])->timestamp;
        
            return $timeB - $timeA;
        });

        // Convert back to an associative array with numeric keys
        $associativeArray = array_values($data);

        return view("studio.keuangan", 
        [
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
        
        $pembelian = Pembelian::select('transaksi_pembelian.*')
            ->join('master_item', 'master_item.id', '=', 'transaksi_pembelian.master_item_id')
            ->join('kategori', 'kategori.id', '=', 'master_item.kategori_id')
            ->join('item', 'item.id', '=', 'master_item.item_id')
            ->where('kategori.toko', '=', 'SGH_Studio')
            ->where('transaksi_pembelian.tanggal', '>=', $timestampStart)
            ->where('transaksi_pembelian.tanggal', '<=', $timestampEnd)
            ->orderBy('transaksi_pembelian.tanggal', 'desc')
            ->with(['barang' => function ($query) {
                $query->with('item');
            }])
            ->get();
        
        $penjualan = PenjualanProdukBarang::select('penjualan_produk_transaksi_pembelian.penjualan_produk_id')
            ->join('transaksi_pembelian', 'transaksi_pembelian.id', '=', 'penjualan_produk_transaksi_pembelian.transaksi_pembelian_id')
            ->join('penjualan_produk', 'penjualan_produk.id', '=', 'penjualan_produk_transaksi_pembelian.penjualan_produk_id')
            ->where('penjualan_produk.tanggal', '>=', $timestampStart)
            ->where('penjualan_produk.tanggal', '<=', $timestampEnd)
            ->groupBy('penjualan_produk_transaksi_pembelian.penjualan_produk_id')
            ->orderBy('penjualan_produk.tanggal', 'desc')
            ->with(['penjualan_produk' => function ($query) {
                $query->with('produk');
            }])
            ->get();
        // return $penjualan;

        // Append results to $data array
        $data = array_merge($pembelian->toArray(), $penjualan->toArray());

        // Sort $data array by 'tanggal' field
        usort($data, function ($a, $b) {
            $timeA = isset($a['tanggal']) ? Carbon::parse($a['tanggal'])->timestamp : 0;
            $timeB = isset($b['tanggal']) ? Carbon::parse($b['tanggal'])->timestamp : 0;
        
            // If 'tanggal' is nested within 'penjualan_produk'
            if (isset($a['penjualan_produk']['tanggal'])) {
                $timeA = Carbon::parse($a['penjualan_produk']['tanggal'])->timestamp;
            }
        
            if (isset($b['penjualan_produk']['tanggal'])) {
                $timeB = Carbon::parse($b['penjualan_produk']['tanggal'])->timestamp;
            }
        
            return $timeB - $timeA;
        });

        // Convert back to an associative array with numeric keys
        $associativeArray = array_values($data);
        
        // return $associativeArray;

        return view("studio.keuangan", 
        [
            "data" => $associativeArray,
        ]);
    }
}
