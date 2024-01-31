<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Bank;

class BrilinkBankController extends Controller
{
    public function index(){
        $bank = Bank::paginate(7);
        return view("brilink.bank", 
        [
            "kategori" => $bank,
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
        Bank::create(
            [
                'nama' => $request->namakategori,
            ]
        );
        return redirect()->route('brilinkbank.index')->with('success', 'menambahkan bank');
    }

    public function edit($id)
    {
        $kategori = Bank::find($id);
        if (!$kategori) {
            // Handle case where the resource is not found
            abort(404, 'Resource not found');
        }
        return view('brilink.bankedit', 
        [
            "kategori" => $kategori,
        ]);
    }

    public function destroy($id)
    {
        $kategori = Bank::find($id);
        if (!$kategori) {
            // Handle case where the resource is not found
            abort(404, 'Resource not found');
        }
        $kategori->delete();
        return redirect()->route('brilinkbank.index')->with('success', 'menghapus bank');
    }

    public function update(Request $request, $id)
    {
        $validator =  $request->validate([
            'nama' => 'required|max:255',
        ], [
            'nama.required' => 'Input nama kategori tidak boleh kosong',
            'nama.max' => 'Input nama kategori tidak boleh lebih dari 255 karakter',
        ]);
        $kategori = Bank::find($id);
        if (!$kategori) {
            // Handle case where the resource is not found
            abort(404, 'Resource not found');
        }
        $kategori->nama = $request->nama;
        $kategori->save();
        return redirect()->route('brilinkbank.index')->with('success', 'mengubah bank');
    }

    public function search(Request $request)
    {
        $searchQuery = $request->input('namakategori');
        
        $kategori = Bank::where('nama', 'like', '%' . $searchQuery . '%')
        ->paginate(7);
        return view("brilink.bank", 
        [
            "kategori" => $kategori,
        ]);
    }
}
