<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pembelian;
use App\Models\Penjualan;
use Carbon\Carbon;

class MotorLaporanKeuanganController extends Controller
{
    /**
     * Display a listing of the resource.
     */
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
            ->where('kategori.toko', '=', 'SGH_Motor')
            ->where('transaksi_pembelian.tanggal', '>=', $timestamp)
            ->where('transaksi_pembelian.tanggal', '<=', $timestamp)
            ->orderBy('transaksi_pembelian.tanggal', 'desc')
            ->with(['barang' => function ($query) {
                $query->with('item');
            }])
            // ->paginate(7);
            ->get();
        
        $penjualan = Penjualan::select('transaksi_penjualan.*')
            ->join('transaksi_pembelian', 'transaksi_pembelian.id', '=', 'transaksi_penjualan.transaksi_pembelian_id')
            ->join('master_item', 'master_item.id', '=', 'transaksi_pembelian.master_item_id')
            ->join('kategori', 'kategori.id', '=', 'master_item.kategori_id')
            ->where('kategori.toko', '=', 'SGH_Motor')
            ->orderBy('transaksi_penjualan.tanggal', 'desc')
            ->where('transaksi_penjualan.tanggal', '>=', $timestamp)
            ->where('transaksi_penjualan.tanggal', '<=', $timestamp)
            ->with(['pembelian' => function ($query) {
                $query->with(['barang' => function ($query) {
                    $query->with('item');
                }]);
            }])
            ->orderBy('transaksi_penjualan.tanggal', 'desc')
            ->get();
            // ->paginate(7);

        // return $penjualan;

        $combinedData = $pembelian->merge($penjualan);

        $sortedData = $combinedData->sortByDesc('tanggal')->values();

        // $combinedData = $pembelian->union($penjualan)->sortByDesc('tanggal')->values();

        // $page = request()->get('page', 1);
        // $perPage = 7;
        // $offset = ($page - 1) * $perPage;

        // $paginatedData = $combinedData->forPage($page, $perPage);

        // return $paginatedData;

        return view("motor.keuangan", 
        [
            "data" => $sortedData,
            // "data" => $paginatedData,
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
            ->where('kategori.toko', '=', 'SGH_Motor')
            ->where('transaksi_pembelian.tanggal', '>=', $timestampStart)
            ->where('transaksi_pembelian.tanggal', '<=', $timestampEnd)
            ->orderBy('transaksi_pembelian.tanggal', 'desc')
            ->with(['barang' => function ($query) {
                $query->with('item');
            }])
            ->get();
        
        $penjualan = Penjualan::select('transaksi_penjualan.*')
            ->join('transaksi_pembelian', 'transaksi_pembelian.id', '=', 'transaksi_penjualan.transaksi_pembelian_id')
            ->join('master_item', 'master_item.id', '=', 'transaksi_pembelian.master_item_id')
            ->join('kategori', 'kategori.id', '=', 'master_item.kategori_id')
            ->where('kategori.toko', '=', 'SGH_Motor')
            ->orderBy('transaksi_penjualan.tanggal', 'desc')
            ->where('transaksi_penjualan.tanggal', '>=', $timestampStart)
            ->where('transaksi_penjualan.tanggal', '<=', $timestampEnd)
            ->with(['pembelian' => function ($query) {
                $query->with(['barang' => function ($query) {
                    $query->with('item');
                }]);
            }])
            ->orderBy('transaksi_penjualan.tanggal', 'desc')
            ->get();

        $combinedData = $pembelian->merge($penjualan);

        $sortedData = $combinedData->sortByDesc('tanggal')->values();

        return view("motor.keuangan", 
        [
            "data" => $sortedData,
        ]);
    }
}
