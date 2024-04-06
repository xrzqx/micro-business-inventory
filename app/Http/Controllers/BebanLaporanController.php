<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\Beban;

class BebanLaporanController extends Controller
{
    public function index(){
        $currentTimestamp = Carbon::now();
        $formattedDate = $currentTimestamp->format('d-m-Y');
        $timestamp = Carbon::parse($formattedDate)->timestamp;

        $beban = Beban::select('beban.kategori_id', \DB::raw('SUM(beban.harga) as jumlah'))
            ->join('kategori', 'kategori.id', '=', 'beban.kategori_id')
            ->where('beban.tanggal', '>=', $timestamp)
            ->where('beban.tanggal', '<=', $timestamp)
            ->groupBy('beban.kategori_id')
            ->orderBy('beban.tanggal', 'desc')
            ->with('kategori')
            ->get();

        // return $beban;
        return view("beban.laporanbeban", 
        [
            "tanggalStart" => $formattedDate,
            "tanggalEnd" => $formattedDate,
            "beban" => $beban
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
        if (!$searchStart) {
            $timestampMinTx = Beban::select(\DB::raw('min(beban.tanggal) as tanggal'))->first();
            $dateTx = Carbon::createFromTimestamp($timestampMinTx);
            $searchStart = $dateTx->format('d-m-Y');
        }
        $timestampStart = Carbon::parse($searchStart)->timestamp;
        $timestampEnd = Carbon::parse($searchEnd)->timestamp;

        $beban = Beban::select('beban.kategori_id', \DB::raw('SUM(beban.harga) as jumlah'))
            ->join('kategori', 'kategori.id', '=', 'beban.kategori_id')
            ->where('beban.tanggal', '>=', $timestampStart)
            ->where('beban.tanggal', '<=', $timestampEnd)
            ->groupBy('beban.kategori_id')
            ->orderBy('beban.tanggal', 'desc')
            ->with('kategori')
            ->get();

        return view("beban.laporanbeban", 
        [
            "tanggalStart" => $searchStart,
            "tanggalEnd" => $searchEnd,
            "beban" => $beban
        ]);
    }
}
