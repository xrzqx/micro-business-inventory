<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Customer;
use App\Models\Penjualan;
use Carbon\Carbon;

class MotorLaporanCustomerController extends Controller
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

        $penjualan = Penjualan::select('transaksi_penjualan.customer_id', \DB::raw('SUM(transaksi_penjualan.jumlah) as total_jumlah'))
            ->join('transaksi_pembelian', 'transaksi_pembelian.id', '=', 'transaksi_penjualan.transaksi_pembelian_id')
            ->join('customer', 'customer.id', '=', 'transaksi_penjualan.customer_id')
            ->join('master_item', 'master_item.id', '=', 'transaksi_pembelian.master_item_id')
            ->join('kategori', 'kategori.id', '=', 'master_item.kategori_id')
            // ->join('item', 'item.id', '=', 'master_item.item_id')
            ->where('kategori.toko', '=', 'SGH_Motor')
            ->where('customer.module', '=', 'SGH_Motor')
            ->where('transaksi_penjualan.tanggal', '>=', $timestamp)
            ->where('transaksi_penjualan.tanggal', '<=', $timestamp)
            ->groupBy('transaksi_penjualan.customer_id')
            ->orderBy(\DB::raw('SUM(transaksi_penjualan.jumlah)'), 'desc')
            ->with('customer')
            ->with(['pembelian' => function ($query) {
                $query->with(['barang' => function ($query) {
                    $query->with(['item', 'kategori']);
                }]);
            }])
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

        return view("motor.laporancustomer", 
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

        $penjualan = Penjualan::select('transaksi_penjualan.customer_id', \DB::raw('SUM(transaksi_penjualan.jumlah) as total_jumlah'))
            ->join('transaksi_pembelian', 'transaksi_pembelian.id', '=', 'transaksi_penjualan.transaksi_pembelian_id')
            ->join('customer', 'customer.id', '=', 'transaksi_penjualan.customer_id')
            ->join('master_item', 'master_item.id', '=', 'transaksi_pembelian.master_item_id')
            ->join('kategori', 'kategori.id', '=', 'master_item.kategori_id')
            // ->join('item', 'item.id', '=', 'master_item.item_id')
            ->where('kategori.toko', '=', 'SGH_Motor')
            ->where('customer.module', '=', 'SGH_Motor')
            ->where('transaksi_penjualan.tanggal', '>=', $timestampStart)
            ->where('transaksi_penjualan.tanggal', '<=', $timestampEnd)
            ->groupBy('transaksi_penjualan.customer_id')
            ->orderBy(\DB::raw('SUM(transaksi_penjualan.jumlah)'), 'desc')
            ->with('customer')
            ->with(['pembelian' => function ($query) {
                $query->with(['barang' => function ($query) {
                    $query->with(['item', 'kategori']);
                }]);
            }])
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

        return view("motor.laporancustomer", 
        [
            "tanggalStart" => $searchStart,
            "tanggalEnd" => $searchEnd,
            "data" => $data,
        ]);
    }
    
}
