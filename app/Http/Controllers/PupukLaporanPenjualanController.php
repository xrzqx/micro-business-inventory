<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Penjualan;
use App\Models\InvoiceItem;
use Carbon\Carbon;

class PupukLaporanPenjualanController extends Controller
{
    //
    public function index(){
        $currentTimestamp = Carbon::now();
        $formattedDate = $currentTimestamp->format('d-m-Y');
        $timestamp = Carbon::parse($formattedDate)->timestamp;

        $penjualan = InvoiceItem::select('invoice_item.transaksi_pembelian_id', \DB::raw('SUM(invoice_item.jumlah) as total_jumlah'), \DB::raw('SUM(invoice_item.total_harga) as total_harga'))
            ->join('invoice', 'invoice.id', '=', 'invoice_item.invoice_id')
            ->join('transaksi_pembelian', 'transaksi_pembelian.id', '=', 'invoice_item.transaksi_pembelian_id')
            ->join('master_item', 'master_item.id', '=', 'transaksi_pembelian.master_item_id')
            ->join('kategori', 'kategori.id', '=', 'master_item.kategori_id')
            ->where('kategori.toko', '=', 'pupuk')
            ->where('invoice.tanggal', '>=', $timestamp)
            ->where('invoice.tanggal', '<=', $timestamp)
            ->groupBy('invoice_item.transaksi_pembelian_id')
            ->orderBy('invoice.tanggal', 'desc')
            ->with(['pembelian' => function ($query) {
                $query->with(['barang' => function ($query) {
                    $query->with('item');
                }]);
            }])
            ->paginate(8);

        $totalLaba = 0;
        foreach ($penjualan as $value) {
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

        $penjualan = InvoiceItem::select('invoice_item.transaksi_pembelian_id', \DB::raw('SUM(invoice_item.jumlah) as total_jumlah'), \DB::raw('SUM(invoice_item.total_harga) as total_harga'))
            ->join('invoice', 'invoice.id', '=', 'invoice_item.invoice_id')
            ->join('transaksi_pembelian', 'transaksi_pembelian.id', '=', 'invoice_item.transaksi_pembelian_id')
            ->join('master_item', 'master_item.id', '=', 'transaksi_pembelian.master_item_id')
            ->join('kategori', 'kategori.id', '=', 'master_item.kategori_id')
            ->where('kategori.toko', '=', 'pupuk')
            ->where('invoice.tanggal', '>=', $timestampStart)
            ->where('invoice.tanggal', '<=', $timestampEnd)
            ->groupBy('invoice_item.transaksi_pembelian_id')
            ->orderBy('invoice.tanggal', 'desc')
            ->with(['pembelian' => function ($query) {
                $query->with(['barang' => function ($query) {
                    $query->with('item');
                }]);
            }])
            ->paginate(8);

        $totalLaba = 0;
        foreach ($penjualan as $value) {
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
