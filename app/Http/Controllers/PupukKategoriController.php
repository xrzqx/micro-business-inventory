<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Kategori;

class PupukKategoriController extends Controller
{
    //
    public function index(){
        $kategori = Kategori::where('toko', '=', 'pupuk')->paginate(7);
        return view("pupuk.kategori", 
        [
            "kategori" => $kategori,
        ]);
    }
    public function store(Request $request)
    {
        $validator =  $request->validate([
            'namakategori' => 'required|max:255',
        ], [
            'namakategori.required' => 'Input nama kategori tidak boleh kosong',
            'namakategori.max' => 'Input nama kategori tidak boleh lebih dari 255 karakter',
        ]);
        Kategori::create(
            [
                'nama' => $request->namakategori,
                'toko' => 'pupuk'
            ]
        );

        return redirect()->route('pupukkategori.index')->with('success', 'menambahkan kategori');
    }

    public function edit($id)
    {
        $kategori = Kategori::find($id);
        if (!$kategori) {
            // Handle case where the resource is not found
            abort(404, 'Resource not found');
        }
        return view('pupuk.kategoriedit', 
        [
            "kategori" => $kategori,
        ]);
    }

    public function destroy($id)
    {
        $kategori = Kategori::find($id);
        if (!$kategori) {
            // Handle case where the resource is not found
            abort(404, 'Resource not found');
        }
        $kategori->delete();
        return redirect()->route('pupukkategori.index')->with('success', 'menghapus kategori');
    }

    public function update(Request $request, $id)
    {
        $validator =  $request->validate([
            'nama' => 'required|max:255',
        ], [
            'nama.required' => 'Input nama kategori tidak boleh kosong',
            'nama.max' => 'Input nama kategori tidak boleh lebih dari 255 karakter',
        ]);
        $kategori = Kategori::find($id);
        if (!$kategori) {
            // Handle case where the resource is not found
            abort(404, 'Resource not found');
        }
        $kategori->nama = $request->nama;
        $kategori->save();
        return redirect()->route('pupukkategori.index')->with('success', 'mengubah kategori');
    }

    public function search(Request $request)
    {
        $searchQuery = $request->input('namakategori');
        
        $kategori = Kategori::where('toko', '=', 'pupuk')
        ->where('nama', 'like', '%' . $searchQuery . '%')
        ->paginate(7);
        return view("pupuk.kategori", 
        [
            "kategori" => $kategori,
        ]);
    }
}
