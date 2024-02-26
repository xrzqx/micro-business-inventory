<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pinjaman;
use Carbon\Carbon;

class PinjamanLaporanKeuanganController extends Controller
{
    //
    public function index(){
        //
        $currentTimestamp = Carbon::now();
        $formattedDate = $currentTimestamp->format('d-m-Y');
        $timestamp = Carbon::parse($formattedDate)->timestamp;

        $pinjaman = Pinjaman::select('pinjaman.customer_id', \DB::raw('SUM(pinjaman.debit) as total_debit'), \DB::raw('SUM(pinjaman.kredit) as total_kredit'))
            ->join('customer', 'customer.id', '=', 'pinjaman.customer_id')
            ->where('pinjaman.tanggal', '>=', $timestamp)
            ->where('pinjaman.tanggal', '<=', $timestamp)
            ->groupBy('pinjaman.customer_id')
            ->orderBy('pinjaman.tanggal', 'desc')
            ->with('customer')
            ->get();

        return view("pinjaman.keuangan", 
        [
            "tanggalStart" => $formattedDate,
            "tanggalEnd" => $formattedDate,
            "data" => $pinjaman,
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

        $pinjaman = Pinjaman::select('pinjaman.customer_id', \DB::raw('SUM(pinjaman.debit) as total_debit'), \DB::raw('SUM(pinjaman.kredit) as total_kredit'))
            ->join('customer', 'customer.id', '=', 'pinjaman.customer_id')
            ->where('pinjaman.tanggal', '>=', $timestampStart)
            ->where('pinjaman.tanggal', '<=', $timestampEnd)
            ->groupBy('pinjaman.customer_id')
            ->orderBy('pinjaman.tanggal', 'desc')
            ->with('customer')
            ->get();

        // return $pinjaman;

        return view("pinjaman.keuangan", 
        [
            "tanggalStart" => $searchStart,
            "tanggalEnd" => $searchEnd,
            "data" => $pinjaman,
        ]);
    }
}
