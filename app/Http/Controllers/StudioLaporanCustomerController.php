<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Customer;
use App\Models\PenjualanProduk;
use Carbon\Carbon;

class StudioLaporanCustomerController extends Controller
{
    //
    public function index(){
        
        $customer = Customer::where('module', '=', 'SGH_Motor')->get();

        // Initialize an empty array to store "nama" values
        $namaArray = [];
        $data = [];

        $currentTimestamp = Carbon::now();
        $formattedDate = $currentTimestamp->format('d-m-Y');
        $timestamp = Carbon::parse($formattedDate)->timestamp;

        $penjualan = PenjualanProduk::select('penjualan_produk.customer_id', \DB::raw('SUM(penjualan_produk.jumlah) as total_jumlah'))
            ->join('customer', 'customer.id', '=', 'penjualan_produk.customer_id')
            ->where('customer.module', '=', 'SGH_Studio')
            ->where('penjualan_produk.tanggal', '>=', $timestamp)
            ->where('penjualan_produk.tanggal', '<=', $timestamp)
            ->groupBy('penjualan_produk.customer_id')
            ->orderBy(\DB::raw('SUM(penjualan_produk.jumlah)'), 'desc')
            ->with('customer')
            ->get();
        
        // return $penjualan;

        foreach ($penjualan as $value) {
            $namaArray[] = $value->customer->nama;
            $data[] = $value->total_jumlah;
        }

        $data = [
            'labels' => $namaArray,
            'data' => $data,
        ];

        return view("studio.laporancustomer", 
        [
            "tanggalStart" => $formattedDate,
            "tanggalEnd" => $formattedDate,
            "data" => $data,
        ]);
    }

    public function search(Request $request){

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
        
        $customer = Customer::where('module', '=', 'SGH_Motor')->get();

        // Initialize an empty array to store "nama" values
        $namaArray = [];
        $data = [];

        $currentTimestamp = Carbon::now();
        $formattedDate = $currentTimestamp->format('d-m-Y');
        $timestamp = Carbon::parse($formattedDate)->timestamp;

        $penjualan = PenjualanProduk::select('penjualan_produk.customer_id', \DB::raw('SUM(penjualan_produk.jumlah) as total_jumlah'))
            ->join('customer', 'customer.id', '=', 'penjualan_produk.customer_id')
            ->where('customer.module', '=', 'SGH_Studio')
            ->where('penjualan_produk.tanggal', '>=', $timestampStart)
            ->where('penjualan_produk.tanggal', '<=', $timestampEnd)
            ->groupBy('penjualan_produk.customer_id')
            ->orderBy(\DB::raw('SUM(penjualan_produk.jumlah)'), 'desc')
            ->with('customer')
            ->get();
        
        // return $penjualan;

        foreach ($penjualan as $value) {
            $namaArray[] = $value->customer->nama;
            $data[] = $value->total_jumlah;
        }

        $data = [
            'labels' => $namaArray,
            'data' => $data,
        ];

        return view("studio.laporancustomer", 
        [
            "tanggalStart" => $searchStart,
            "tanggalEnd" => $searchEnd,
            "data" => $data,
        ]);
    }
    
}
