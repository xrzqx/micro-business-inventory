<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pembelian;
use App\Models\Penjualan;
use App\Models\InvoiceItem;
use App\Models\Kategori;
use Carbon\Carbon;

class PupukLaporanKeuanganController extends Controller
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

        $kategoriOpt = Kategori::select(['kategori.id','kategori.nama'])
            ->where('toko', 'pupuk')
            ->get();

        $kategori_selected = [];
        
        $pembelian = Pembelian::select('transaksi_pembelian.master_item_id', \DB::raw('SUM(transaksi_pembelian.harga) as total_harga'))
            ->join('master_item', 'master_item.id', '=', 'transaksi_pembelian.master_item_id')
            ->join('kategori', 'kategori.id', '=', 'master_item.kategori_id')
            ->join('item', 'item.id', '=', 'master_item.item_id')
            ->where('kategori.toko', '=', 'pupuk')
            ->where('transaksi_pembelian.tanggal', '>=', $timestamp)
            ->where('transaksi_pembelian.tanggal', '<=', $timestamp)
            ->groupBy('transaksi_pembelian.master_item_id')
            ->orderBy('transaksi_pembelian.tanggal', 'desc')
            ->with(['barang' => function ($query) {
                $query->with('item');
            }])
            // ->paginate(7);
            ->get();
        
        // return $pembelian;
        
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
            ->get();
            // ->paginate(7);

        // return $penjualan;

        // Append results to $data array
        $data = array_merge($pembelian->toArray(), $penjualan->toArray());
        $associativeArray = array_values($data);

        // return $data;

        return view("pupuk.keuangan", 
        [
            "tanggalStart" => $formattedDate,
            "tanggalEnd" => $formattedDate,
            "kategori" => $kategoriOpt,
            "kategori_selected" => $kategori_selected,
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

        $kategoriOpt = Kategori::select(['kategori.id','kategori.nama'])
            ->where('toko', 'pupuk')
            ->get();

        $kategori_selected = $request->input('kategori', []);
        // return $kategori_selected;
        // return $kategori_selected;
        
        $pembelian = Pembelian::select('transaksi_pembelian.master_item_id', \DB::raw('SUM(transaksi_pembelian.harga) as total_harga'))
            ->join('master_item', 'master_item.id', '=', 'transaksi_pembelian.master_item_id')
            ->join('kategori', 'kategori.id', '=', 'master_item.kategori_id')
            ->join('item', 'item.id', '=', 'master_item.item_id')
            // ->where('kategori.toko', '=', 'pupuk')
            ->where('transaksi_pembelian.tanggal', '>=', $timestampStart)
            ->where('transaksi_pembelian.tanggal', '<=', $timestampEnd)
            ->whereIn('kategori.id', $kategori_selected)
            ->groupBy('transaksi_pembelian.master_item_id')
            ->orderBy('transaksi_pembelian.tanggal', 'desc')
            ->with(['barang' => function ($query) {
                $query->with('item');
            }])
            // ->paginate(7);
            ->get();

        $penjualan = InvoiceItem::select('invoice_item.transaksi_pembelian_id', \DB::raw('SUM(invoice_item.jumlah) as total_jumlah'), \DB::raw('SUM(invoice_item.total_harga) as total_harga'))
            ->join('invoice', 'invoice.id', '=', 'invoice_item.invoice_id')
            ->join('transaksi_pembelian', 'transaksi_pembelian.id', '=', 'invoice_item.transaksi_pembelian_id')
            ->join('master_item', 'master_item.id', '=', 'transaksi_pembelian.master_item_id')
            ->join('kategori', 'kategori.id', '=', 'master_item.kategori_id')
            ->where('kategori.toko', '=', 'pupuk')
            ->where('invoice.tanggal', '>=', $timestampStart)
            ->where('invoice.tanggal', '<=', $timestampEnd)
            ->whereIn('kategori.id', $kategori_selected)
            ->groupBy('invoice_item.transaksi_pembelian_id')
            ->orderBy('invoice.tanggal', 'desc')
            ->with(['pembelian' => function ($query) {
                $query->with(['barang' => function ($query) {
                    $query->with('item');
                }]);
            }])
            ->get();
        // return $pembelian;

        // Append results to $data array
        $data = array_merge($pembelian->toArray(), $penjualan->toArray());

        // Sort $data array by 'tanggal' field
        // usort($data, function ($a, $b) {
        //     $timeA = Carbon::parse($a['tanggal'])->timestamp;
        //     $timeB = Carbon::parse($b['tanggal'])->timestamp;
        
        //     return $timeB - $timeA;
        // });

        // Convert back to an associative array with numeric keys
        $associativeArray = array_values($data);

        return view("pupuk.keuangan", 
        [
            "tanggalStart" => $searchStart,
            "tanggalEnd" => $searchEnd,
            "kategori" => $kategoriOpt,
            "kategori_selected" => $kategori_selected,
            "data" => $associativeArray,
        ]);
    }
}
