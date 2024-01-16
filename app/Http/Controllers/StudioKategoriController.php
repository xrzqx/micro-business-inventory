<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Kategori;

class StudioKategoriController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $kategori = Kategori::where('toko', '=', 'SGH_Studio')->paginate(7);
        return view("studio.kategori", 
        [
            "kategori" => $kategori,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $validator =  $request->validate([
            'namakategori' => 'required|max:255',
        ], [
            'namakategori.required' => 'Input nama kategori tidak boleh kosong',
            'namakategori.max' => 'Input nama kategori tidak boleh lebih dari 255 karakter',
        ]);
        Kategori::create(
            [
                'nama' => $request->namakategori,
                'toko' => 'SGH_Studio'
            ]
        );

        return redirect()->route('studiokategori.index')->with('success', 'menambahkan kategori');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
        $kategori = Kategori::find($id);
        if (!$kategori) {
            // Handle case where the resource is not found
            abort(404, 'Resource not found');
        }
        return view('studio.kategoriedit', 
        [
            "kategori" => $kategori,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
        $validator =  $request->validate([
            'nama' => 'required|max:255',
        ], [
            'nama.required' => 'Input nama kategori tidak boleh kosong',
            'nama.max' => 'Input nama kategori tidak boleh lebih dari 255 karakter',
        ]);
        $kategori = Kategori::find($id);
        $kategori->nama = $request->nama;
        $kategori->save();
        if (!$kategori) {
            // Handle case where the resource is not found
            abort(404, 'Resource not found');
        }
        return redirect()->route('studiokategori.index')->with('success', 'mengubah kategori');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
        $kategori = Kategori::find($id);
        if (!$kategori) {
            // Handle case where the resource is not found
            abort(404, 'Resource not found');
        }
        $kategori->delete();
        return redirect()->route('studiokategori.index')->with('success', 'menghapus kategori');
    }

    public function search(Request $request)
    {
        //
        $searchQuery = $request->input('namakategori');
        
        $kategori = Kategori::where('toko', '=', 'SGH_Studio')
        ->where('nama', 'like', '%' . $searchQuery . '%')
        ->paginate(7);
        return view("studio.kategori", 
        [
            "kategori" => $kategori,
        ]);
    }
}
