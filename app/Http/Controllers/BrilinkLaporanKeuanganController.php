<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Brilink;
use Carbon\Carbon;

class BrilinkLaporanKeuanganController extends Controller
{
    //
    public function index(){
        //
        $currentTimestamp = Carbon::now();
        $formattedDate = $currentTimestamp->format('d-m-Y');
        $timestamp = Carbon::parse($formattedDate)->timestamp;

        $trx = Brilink::select('brilink.bank_id', \DB::raw('SUM(brilink.jumlah) as kredit'), \DB::raw('SUM(brilink.admin) as total_admin'))
            ->join('bank', 'bank.id', '=', 'brilink.bank_id')
            ->where('brilink.tanggal', '>=', $timestamp)
            ->where('brilink.tanggal', '<=', $timestamp)
            ->groupBy('brilink.bank_id')
            ->with('bank')
            ->get();

        return view("brilink.keuangan", 
        [
            "data" => $trx,
        ]);
    }

    public function search(Request $request)
    {
        $searchStart = $request->input('start');
        $searchEnd = $request->input('end');

        // Convert the selected date to a timestamp (UNIX timestamp)
        $timestampStart = Carbon::parse($searchStart)->timestamp;
        $timestampEnd = Carbon::parse($searchEnd)->timestamp;

        $trx = Brilink::select('brilink.bank_id', \DB::raw('SUM(brilink.jumlah) as kredit'), \DB::raw('SUM(brilink.admin) as total_admin'))
            ->join('bank', 'bank.id', '=', 'brilink.bank_id')
            ->where('brilink.tanggal', '>=', $timestampStart)
            ->where('brilink.tanggal', '<=', $timestampEnd)
            ->groupBy('brilink.bank_id')
            ->with('bank')
            ->get();
        // return $trx;

        return view("brilink.keuangan", 
        [
            "data" => $trx,
        ]);
    }
}
