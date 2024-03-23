<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Penjualan;
use App\Models\Kategori;
use Carbon\Carbon;

class MotorLaporanLabaBulanController extends Controller
{
    //
    public function index(){

        $searchYear = Carbon::now()->year;

        $timestampStart = Carbon::createFromFormat('Y-m-d H:i:s', "$searchYear-01-01 00:00:00")->timestamp;
        $timestampEnd = Carbon::createFromFormat('Y-m-d H:i:s', "$searchYear-12-31 23:59:59")->timestamp;

        // Generate a list of all months within the date range
        $allMonths = collect();
        $startDate = Carbon::createFromTimestamp($timestampStart)->startOfMonth();
        $endDate = Carbon::createFromTimestamp($timestampEnd)->endOfMonth();

        
        while ($startDate->lessThanOrEqualTo($endDate)) {
            $allMonths->push([
                'year' => $startDate->year,
                'month' => $startDate->month,
            ]);
            $startDate->addMonth();
        }

        // \DB::listen(function ($query) {
        //     \Log::info('Query Executed: ' . $query->sql, ['bindings' => $query->bindings, 'time' => $query->time]);
        // });
        
        // return $allMonths;
        // Query sales data for each month
        $penjualan_laba = $allMonths->map(function ($month) {
            return Penjualan::select(
                    'transaksi_penjualan.transaksi_pembelian_id',
                    // \DB::raw($month['year'] . ' as year'),
                    // \DB::raw($month['month'] . ' as month'),
                    \DB::raw('IFNULL(SUM(transaksi_penjualan.jumlah), 0) as total_jumlah'),
                    \DB::raw('IFNULL(SUM(transaksi_penjualan.harga), 0) as total_harga')
                )
                ->join('transaksi_pembelian', 'transaksi_pembelian.id', '=', 'transaksi_penjualan.transaksi_pembelian_id')
                ->join('master_item', 'master_item.id', '=', 'transaksi_pembelian.master_item_id')
                ->join('kategori', 'kategori.id', '=', 'master_item.kategori_id')
                ->where('kategori.toko', '=', 'SGH_Motor')
                ->whereYear(\DB::raw('FROM_UNIXTIME(transaksi_penjualan.tanggal)'), $month['year'])
                ->whereMonth(\DB::raw('FROM_UNIXTIME(transaksi_penjualan.tanggal)'), $month['month'])
                // ->groupBy('year', 'month')
                ->groupBy('transaksi_penjualan.transaksi_pembelian_id')
                ->with(['pembelian' => function ($query) {
                    $query->with(['barang' => function ($query) {
                        $query->with(['item','kategori']);
                    }]);
                }])
                ->get();
        });
        $monthNumber  = 1;
        $laba_bulan = [];
        foreach ($penjualan_laba as $innerArray) {
            // $totalLaba = 0;
            // echo $cc;
            $monthName = Carbon::create()->month($monthNumber)->monthName;
            $laba_bulan[$monthName] = 0;
            if (count($innerArray) !== 0) {
                foreach ($innerArray as $value) {
                    $total_hb = ($value->pembelian->harga / $value->pembelian->jumlah) * $value->total_jumlah;
                    $laba_bulan[$monthName] += $value->total_harga - $total_hb;
                }
            }
            $monthNumber ++;
        }

        $namaArray = [];
        $jumlahArray = [];

        foreach ($laba_bulan as $key => $value) {
            $namaArray[] = $key;
            $jumlahArray[] = $value;
        }

        $data = [
            "labels" => $namaArray,
            "data" => $jumlahArray,
        ];

        return view("motor.laporanlababulan",
        [
            // "kategori" => $kategoriOpt,
            // "kategori_selected" => $kategori_selected,
            "tahunStart" => $searchYear,
            "data" => $data,
        ]);
    }

    public function search(Request $request)
    {
        $searchYear = $request->input('year');

        if (!$searchYear) {
            $searchYear = Carbon::now()->year;
        }

        // Calculate start and end timestamps for the given year
        $timestampStart = Carbon::createFromFormat('Y-m-d H:i:s', "$searchYear-01-01 00:00:00")->timestamp;
        $timestampEnd = Carbon::createFromFormat('Y-m-d H:i:s', "$searchYear-12-31 23:59:59")->timestamp;

        // Generate a list of all months within the date range
        $allMonths = collect();
        $startDate = Carbon::createFromTimestamp($timestampStart)->startOfMonth();
        $endDate = Carbon::createFromTimestamp($timestampEnd)->endOfMonth();

        
        while ($startDate->lessThanOrEqualTo($endDate)) {
            $allMonths->push([
                'year' => $startDate->year,
                'month' => $startDate->month,
            ]);
            $startDate->addMonth();
        }

        // \DB::listen(function ($query) {
        //     \Log::info('Query Executed: ' . $query->sql, ['bindings' => $query->bindings, 'time' => $query->time]);
        // });
        
        // return $allMonths;
        // Query sales data for each month
        $penjualan_laba = $allMonths->map(function ($month) {
            return Penjualan::select(
                    'transaksi_penjualan.transaksi_pembelian_id',
                    // \DB::raw($month['year'] . ' as year'),
                    // \DB::raw($month['month'] . ' as month'),
                    \DB::raw('IFNULL(SUM(transaksi_penjualan.jumlah), 0) as total_jumlah'),
                    \DB::raw('IFNULL(SUM(transaksi_penjualan.harga), 0) as total_harga')
                )
                ->join('transaksi_pembelian', 'transaksi_pembelian.id', '=', 'transaksi_penjualan.transaksi_pembelian_id')
                ->join('master_item', 'master_item.id', '=', 'transaksi_pembelian.master_item_id')
                ->join('kategori', 'kategori.id', '=', 'master_item.kategori_id')
                ->where('kategori.toko', '=', 'SGH_Motor')
                ->whereYear(\DB::raw('FROM_UNIXTIME(transaksi_penjualan.tanggal)'), $month['year'])
                ->whereMonth(\DB::raw('FROM_UNIXTIME(transaksi_penjualan.tanggal)'), $month['month'])
                // ->groupBy('year', 'month')
                ->groupBy('transaksi_penjualan.transaksi_pembelian_id')
                ->with(['pembelian' => function ($query) {
                    $query->with(['barang' => function ($query) {
                        $query->with(['item','kategori']);
                    }]);
                }])
                ->get();
        });
        $monthNumber  = 1;
        $laba_bulan = [];
        foreach ($penjualan_laba as $innerArray) {
            // $totalLaba = 0;
            // echo $cc;
            $monthName = Carbon::create()->month($monthNumber)->monthName;
            $laba_bulan[$monthName] = 0;
            if (count($innerArray) !== 0) {
                foreach ($innerArray as $value) {
                    $total_hb = ($value->pembelian->harga / $value->pembelian->jumlah) * $value->total_jumlah;
                    $laba_bulan[$monthName] += $value->total_harga - $total_hb;
                }
            }
            $monthNumber ++;
        }

        $namaArray = [];
        $jumlahArray = [];

        foreach ($laba_bulan as $key => $value) {
            $namaArray[] = $key;
            $jumlahArray[] = $value;
        }

        $data = [
            "labels" => $namaArray,
            "data" => $jumlahArray,
        ];

        return view("motor.laporanlababulan", 
        [
            // "kategori" => $kategoriOpt,
            // "kategori_selected" => $kategori_selected,
            "tahunStart" => $searchYear,
            "data" => $data,
        ]);
    }
}
