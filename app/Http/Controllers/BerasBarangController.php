<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Barang;
use App\Models\Item;
use App\Models\Kategori;
use Illuminate\Database\Eloquent\Builder;

class BerasBarangController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $barang = Barang::with('item', 'kategori')
            ->whereHas('kategori', function (Builder $query) {
                $query->where('toko', '=', 'beras');
            })
            ->paginate(7);
        $kategori = Kategori::all()->where('toko', '=', 'beras');
        // $barang = Item::all();
        return view("beras.barang", 
        [
            "barang" => $barang,
            "kategori" => $kategori,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
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

        return redirect()->route('beras.index')->with('success', 'menambahkan barang');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
        $barang = Barang::with('item', 'kategori')
            ->whereHas('kategori', function (Builder $query) {
                $query->where('toko', '=', 'beras');
            })
            ->where('id' , $id)
            ->get();
        $kategori = Kategori::all()->where('toko', '=', 'beras');
        if (!$barang) {
            // Handle case where the resource is not found
            abort(404, 'Resource not found');
        }
        return view('beras.barangedit', 
        [
            "barang" => $barang,
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
        

        return redirect()->route('beras.index')->with('success', 'mengubah barang');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
        $barang = Barang::find($id);
        if (!$barang) {
            // Handle case where the resource is not found
            abort(404, 'Resource not found');
        }
        $item = Item::find($barang->item->id);
        try {
            $barang->delete();
            $item->delete();
        } catch (\Illuminate\Database\QueryException $e) {
            return response()->json(['error' => 'Database error'], 500);
            // Handle the exception, log it, or provide a user-friendly message
            return redirect()->route('beras.index')->with('failed', 'menghapus barang');
        }
        return redirect()->route('beras.index')->with('success', 'menghapus barang');
    }

    public function search(Request $request)
    {
        $searchQuery = $request->input('namabarang');
        
        $barang = Barang::select('master_item.*')
        // ->join('master_item', 'master_item.id', '=', 'transaksi_pembelian.master_item_id')
        ->join('kategori', 'kategori.id', '=', 'master_item.kategori_id')
        ->join('item', 'item.id', '=', 'master_item.item_id')
        ->where('kategori.toko', '=', 'beras')
        ->where('item.nama', 'like', '%' . $searchQuery . '%')
        // ->distinct()
        ->with('item','kategori')
        ->paginate(7);

        $kategori = Kategori::where('toko', '=', 'beras')->get();

        return view("beras.barang",
        [
            "barang" => $barang,
            "kategori" => $kategori,
        ]);
    }
}
