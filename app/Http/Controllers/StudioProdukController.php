<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Produk;

class StudioProdukController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $produk = Produk::paginate(7);
        return view("studio.produk", 
        [
            'produk' => $produk,
        ]);
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $validator =  $request->validate([
            'nama' => 'required|max:255',
        ], [
            'nama.required' => 'Input nama kategori tidak boleh kosong',
            'nama.max' => 'Input nama kategori tidak boleh lebih dari 255 karakter',
        ]);
        Produk::create(
            [
                'nama' => $request->nama,
            ]
        );

        return redirect()->route('studioproduk.index')->with('success', 'menambahkan produk');
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $produk = Produk::find($id);
        if (!$produk) {
            // Handle case where the resource is not found
            abort(404, 'Resource not found');
        }
        return view('studio.produkedit', 
        [
            "produk" => $produk,
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
        $produk = Produk::find($id);
        if (!$produk) {
            // Handle case where the resource is not found
            abort(404, 'Resource not found');
        }
        $produk->nama = $request->nama;
        $produk->save();
        return redirect()->route('studioproduk.index')->with('success', 'mengubah kategori');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
        $produk = Produk::find($id);
        if (!$produk) {
            // Handle case where the resource is not found
            abort(404, 'Resource not found');
        }
        $produk->delete();
        return redirect()->route('studioproduk.index')->with('success', 'menghapus produk');
    }

    public function search(Request $request)
    {
        //
        $searchQuery = $request->input('namaproduk');
        
        $produk = Produk::where('nama', 'like', '%' . $searchQuery . '%')
        ->paginate(7);
        return view("studio.produk", 
        [
            "produk" => $produk,
        ]);
    }
}
