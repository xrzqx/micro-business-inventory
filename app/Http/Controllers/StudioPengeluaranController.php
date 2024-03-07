<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pengeluaran;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class StudioPengeluaranController extends Controller
{
    //
    public function index(){
        $pengeluaran = Pengeluaran::where('toko','studio')->paginate(7);
        // return $pengeluaran;
        return view('studio.pengeluaran',[
            "pengeluaran" => $pengeluaran,
        ]);
    }
    public function store(Request $request)
    {
        $validator =  $request->validate([
            'nama' => 'required|max:255',
            'harga' => 'required|numeric',
            'tanggal' => 'required|max:255',
        ], [
            'nama.required' => 'Input nama barang tidak boleh kosong',
            'nama.max' => 'Input nama tidak boleh lebih dari 50 karakter',
            'harga.required' => 'Input harga tidak boleh kosong',
            'harga.numeric' => 'Input harga harus nomor',
            'tanggal.required' => 'Input tanggal tidak boleh kosong',
            'tanggal.max' => 'Input tanggal tidak boleh lebih dari 255 karakter',
        ]);
        $selectedDate = $request->tanggal;

        // Convert the selected date to a timestamp (UNIX timestamp)
        $timestamp = Carbon::parse($selectedDate)->timestamp;

        DB::beginTransaction();
        try {
            Pengeluaran::create([
                'nama' => $request->nama,
                'harga' => $request->harga,
                // 'tanggal' => $request->tanggal,
                'tanggal' => $timestamp,
                'toko' => 'studio'
            ]);
            // If everything went well, commit the transaction
            DB::commit();
        } catch (\Exception $e) {
            // If an exception occurs, rollback the transaction
            DB::rollBack();

            // Handle the exception or log it as needed
            return response()->json(['error' => 'Transaction failed.'], 500);
        }

        return redirect()->route('studiopengeluaran.index')->with('success', 'menambahkan pengeluaran');
    }

    public function edit($id)
    { 
        $pengeluaran = Pengeluaran::find($id);
        
        if (!$pengeluaran) {
            // Handle case where the resource is not found
            abort(404, 'Resource not found');
        }
        return view('studio.pengeluaranedit', 
        [
            "pengeluaran" => $pengeluaran,
        ]);
    }

    public function update(Request $request, $id)
    {
        $validator =  $request->validate([
            'nama' => 'required|max:255',
            'harga' => 'required|numeric',
            'tanggal' => 'required|max:255',
        ], [
            'nama.required' => 'Input nama barang tidak boleh kosong',
            'nama.max' => 'Input nama tidak boleh lebih dari 50 karakter',
            'harga.required' => 'Input harga tidak boleh kosong',
            'harga.numeric' => 'Input harga harus nomor',
            'tanggal.required' => 'Input tanggal tidak boleh kosong',
            'tanggal.max' => 'Input tanggal tidak boleh lebih dari 255 karakter',
        ]);

        $selectedDate = $request->tanggal;

        // Convert the selected date to a timestamp (UNIX timestamp)
        $timestamp = Carbon::parse($selectedDate)->timestamp;

        $pengeluaran = Pengeluaran::find($id);
        if (!$pengeluaran) {
            // Handle case where the resource is not found
            abort(404, 'Resource not found');
        }
        $pengeluaran->nama = $request->nama;
        $pengeluaran->harga = $request->harga;
        $pengeluaran->tanggal = $timestamp;
        $pengeluaran->save();

        return redirect()->route('studiopengeluaran.index')->with('success', 'mengedit pengeluaran');
    }

    public function destroy($id)
    {
        DB::beginTransaction();
        try {
            $pengeluaran = Pengeluaran::find($id);
            if (!$pengeluaran) {
                // Handle case where the resource is not found
                abort(404, 'Resource not found');
            }
            $pengeluaran->delete();

            // If everything went well, commit the transaction
            DB::commit();
        } catch (\Exception $e) {
            // If an exception occurs, rollback the transaction
            DB::rollBack();

            // Handle the exception or log it as needed
            return response()->json(['error' => 'Transaction failed.'], 500);
        }
        
        return redirect()->route('studiopengeluaran.index')->with('success', 'menghapus pengeluaran');
    }

    public function search(Request $request)
    {
        $searchQuery = $request->input('nama');

        $pengeluaran = Pengeluaran::select('pengeluaran.*')
            ->where('pengeluaran.toko', '=', 'studio')
            ->where('pengeluaran.nama', 'like', '%' . $searchQuery . '%')
            ->paginate(7);

        return view("studio.pengeluaran",
        [
            "pengeluaran" => $pengeluaran,
        ]);
    }
}
