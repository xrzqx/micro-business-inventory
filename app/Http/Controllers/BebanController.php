<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Kategori;
use App\Models\Beban;
use Carbon\Carbon;

class BebanController extends Controller
{
    //
    public function index(){
        $kategori = Kategori::where('toko','beban')->get();
        $beban = Beban::with('kategori')
            ->orderBy('tanggal', 'desc')
            ->paginate(7);
        return view("beban.index", 
        [
            "kategori" => $kategori,
            "beban" => $beban
        ]);
    }

    public function store(Request $request)
    {
        //
        $validator =  $request->validate([
            'kategori' => 'required|numeric',
            'harga' => 'required|numeric',
            'tanggal' => 'required|max:255',
        ], [
            'kategori.required' => 'Input nama kategori tidak boleh kosong',
            'kategori.numeric' => 'Input nama kategori harus benar',
            'harga.required' => 'Input harga tidak boleh kosong',
            'harga.numeric' => 'Input harga harus nomor',
            'kredit.numeric' => 'Input jumlah harus nomor',
            'tanggal.required' => 'Input tanggal tidak boleh kosong',
            'tanggal.max' => 'Input tanggal tidak boleh lebih dari 255 karakter',
        ]);
        // return $request->keterangan;

        $selectedDate = $request->tanggal;

        // Convert the selected date to a timestamp (UNIX timestamp)
        $timestamp = Carbon::parse($selectedDate)->timestamp;

        Beban::create(
            [
                'kategori_id' => $request->kategori,
                'harga' => $request->harga,
                'tanggal' => $timestamp,
            ]
        );

        return redirect()->route('beban.index')->with('success', 'menambahkan beban');
    }

    public function edit(string $id)
    {
        //
        $kategori = Kategori::where('toko','beban')->get();
        $beban = Beban::find($id);
        if (!$beban) {
            // Handle case where the resource is not found
            abort(404, 'Resource not found');
        }
        // return $beban;
        return view('beban.indexedit', 
        [
            "kategori" => $kategori,
            "beban" => $beban,
        ]);
    }

    public function update(Request $request, string $id)
    {
        //
        $validator =  $request->validate([
            'kategori' => 'required|numeric',
            'harga' => 'required|numeric',
            'tanggal' => 'required|max:255',
        ], [
            'kategori.required' => 'Input nama kategori tidak boleh kosong',
            'kategori.numeric' => 'Input nama kategori harus benar',
            'harga.required' => 'Input harga tidak boleh kosong',
            'harga.numeric' => 'Input harga harus nomor',
            'kredit.numeric' => 'Input jumlah harus nomor',
            'tanggal.required' => 'Input tanggal tidak boleh kosong',
            'tanggal.max' => 'Input tanggal tidak boleh lebih dari 255 karakter',
        ]);

        $selectedDate = $request->tanggal;

        // Convert the selected date to a timestamp (UNIX timestamp)
        $timestamp = Carbon::parse($selectedDate)->timestamp;

        $beban = Beban::find($id);
        $beban->kategori_id = $request->kategori;
        $beban->harga = $request->harga;
        $beban->tanggal = $timestamp;
        $beban->save();

        return redirect()->route('beban.index')->with('success', 'mengedit daftar beban');
    }

    public function destroy($id)
    {
        $beban = Beban::find($id);
        if (!$beban) {
            // Handle case where the resource is not found
            abort(404, 'Resource not found');
        }
        $beban->delete();
        return redirect()->route('beban.index')->with('success', 'menghapus pinjaman');
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

        $beban = Beban::select('beban.*')
            ->join('kategori', 'kategori.id', '=', 'beban.kategori_id')
            ->where('kategori.toko','=','beban')
            ->where('beban.tanggal', '>=', $timestampStart)
            ->where('beban.tanggal', '<=', $timestampEnd)
            ->with('kategori')
            ->orderBy('tanggal', 'desc')
            ->paginate(7);

        $kategori = Kategori::where('toko','beban')->get();

        return view("beban.index", 
        [
            "beban" => $beban,
            "kategori" => $kategori,
        ]);
    }
}
