<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Barang;
use App\Models\Item;
use App\Models\Kategori;
use Illuminate\Database\Eloquent\Builder;

class MotorBarangController extends Controller
{
    //
    public function index(){
        $barang = Barang::with('item', 'kategori')
            ->whereHas('kategori', function (Builder $query) {
                $query->where('toko', '=', 'SGH_Motor');
            })
            ->paginate(7);
        $kategori = Kategori::all()->where('toko', '=', 'SGH_Motor');
        // $barang = Item::all();
        return view("motor.barang", 
        [
            "barang" => $barang,
            "kategori" => $kategori,
        ]);
    }

    public function store(Request $request)
    {
        $validator =  $request->validate([
            'kode' => 'required|max:255',
            'nama' => 'required|max:255',
            'kategori' => 'required|max:255',
        ], [
            'kode.required' => 'Input kode produk tidak boleh kosong',
            'kode.max' => 'Input kode produk tidak boleh lebih dari 255 karakter',
            'nama.required' => 'Input nama produk tidak boleh kosong',
            'nama.max' => 'Input nama produk tidak boleh lebih dari 255 karakter',
            'kategori.required' => 'Input kategori tidak boleh kosong',
            'kategori.max' => 'Input kategori tidak boleh lebih dari 255 karakter',
        ]);
        $item = Item::create([
            'kode' => $request->kode,
            'nama' => $request->nama,
        ]);
        Barang::create(
            [
                'item_id' => $item->id,
                'kategori_id' => $request->kategori,
            ]
        );

        return redirect()->route('motor.index')->with('success', 'menambahkan barang');
    }

    public function edit($id)
    {
        $barang = Barang::with('item', 'kategori')
            ->whereHas('kategori', function (Builder $query) {
                $query->where('toko', '=', 'SGH_Motor');
            })
            ->where('id' , $id)
            ->get();
        $kategori = Kategori::all()->where('toko', '=', 'SGH_Motor');
        if (!$barang) {
            // Handle case where the resource is not found
            abort(404, 'Resource not found');
        }
        return view('motor.barangedit', 
        [
            "barang" => $barang,
            "kategori" => $kategori,
        ]);
    }

    public function update(Request $request, $id)
    {
        $validator =  $request->validate([
            'kode' => 'required|max:255',
            'nama' => 'required|max:255',
            'kategori' => 'required|numeric',
        ], [
            'kode.required' => 'Input kode produk tidak boleh kosong',
            'kode.max' => 'Input kode produk tidak boleh lebih dari 255 karakter',
            'nama.required' => 'Input nama produk tidak boleh kosong',
            'nama.max' => 'Input nama produk tidak boleh lebih dari 255 karakter',
            'kategori.required' => 'Input kategori tidak boleh kosong',
            'kategori.numeric' => 'Input kategori harus nomor',
        ]);
        $barang = Barang::find($id);
        if (!$barang) {
            // Handle case where the resource is not found
            abort(404, 'Resource not found');
        }
        $barang->kategori_id = $request->kategori;
        $barang->save();

        $item = Item::find($barang->item_id);
        $item->kode = $request->kode;
        $item->nama = $request->nama;
        $item->save();
        

        return redirect()->route('motor.index')->with('success', 'mengubah barang');
    }

    public function destroy($id)
    {
        $barang = Barang::find($id);
        if (!$barang) {
            // Handle case where the resource is not found
            abort(404, 'Resource not found');
        }
        $item = Item::find($id);
        $barang->delete();
        return redirect()->route('motor.index')->with('success', 'menghapus barang');
    }
}
