<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Limbah;
use App\Models\Pembelian;
use App\Models\Barang;
use App\Models\Item;
use Illuminate\Database\Eloquent\Builder;
use Carbon\Carbon;

class StudioLimbahController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $barang = Pembelian::select('transaksi_pembelian.master_item_id')
            ->join('master_item', 'master_item.id', '=', 'transaksi_pembelian.master_item_id')
            ->join('kategori', 'kategori.id', '=', 'master_item.kategori_id')
            ->join('item', 'item.id', '=', 'master_item.item_id')
            ->where('kategori.toko', '=', 'SGH_Studio')
            ->where('sisa', '>', 0)
            ->groupBy('transaksi_pembelian.master_item_id')
            ->with(['barang' => function ($query) {
                $query->with('item', 'kategori');
            }])
            ->get();

        $pembelian = Pembelian::with(['barang' => function ($query) {
            $query->with('item', 'kategori')
                ->whereHas('kategori', function (Builder $query) {
                    $query->where('toko', '=', 'SGH_Studio');
                });
            }])
            ->where('sisa', '>', 0)
            ->get();
        
        $limbah = Limbah::select('limbah.*')
            ->join('transaksi_pembelian', 'transaksi_pembelian.id', '=', 'limbah.transaksi_pembelian_id')
            ->join('master_item', 'master_item.id', '=', 'transaksi_pembelian.master_item_id')
            ->join('kategori', 'kategori.id', '=', 'master_item.kategori_id')
            ->where('kategori.toko', '=', 'SGH_Studio')
            ->orderBy('limbah.tanggal', 'desc')
            ->with(['pembelian' => function ($query) {
                $query->with(['barang' => function ($query) {
                    $query->with(['item', 'kategori']);
                }]);
            }])
            ->paginate(7);
        
        return view("studio.limbah", 
        [
            "barang" => $barang,
            "pembelian" => $pembelian,
            "limbah" => $limbah,
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
            'nama' => 'required|numeric',
            'batch' => 'required|numeric',
            'jumlah' => 'required|numeric',
            'tanggal' => 'required|max:255',
        ], [
            'nama.required' => 'Input nama barang tidak boleh kosong',
            'nama.numeric' => 'Input nama barang harus benar',
            'batch.required' => 'Input batch barang tidak boleh kosong',
            'batch.numeric' => 'Input nama barang harus benar',
            'jumlah.required' => 'Input jumlah tidak boleh kosong',
            'jumlah.numeric' => 'Input jumlah harus nomor',
            'tanggal.required' => 'Input tanggal tidak boleh kosong',
            'tanggal.max' => 'Input tanggal tidak boleh lebih dari 255 karakter',
        ]);

        $selectedDate = $request->tanggal;

        // Convert the selected date to a timestamp (UNIX timestamp)
        $timestamp = Carbon::parse($selectedDate)->timestamp;

        $barang = Barang::find($request->nama);
        $item = Item::find($barang->item_id);
        // return $item;
        Limbah::create([
            'transaksi_pembelian_id' => $request->batch,
            'jumlah' => $request->jumlah,
            'tanggal' => $timestamp,
        ]);

        $item->stock = $item->stock - $request->jumlah;
        $item->save();

        $pembelian = Pembelian::find($request->batch);
        $pembelian->sisa = $pembelian->sisa - $request->jumlah;
        $pembelian->save();

        return redirect()->route('studiolimbah.index')->with('success', 'menambahkan limbah barang');
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
        return "hehe";
        // $limbah = Limbah::find($id);
        // if (!$limbah) {
        //     // Handle case where the resource is not found
        //     abort(404, 'Resource not found');
        // }
        // return view('studio.limbahedit', 
        // [
        //     "limbah" => $limbah,
        // ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
        $limbah = Limbah::find($id);
        if (!$limbah) {
            // Handle case where the resource is not found
            abort(404, 'Resource not found');
        }

        $pembelian = Pembelian::find($limbah->transaksi_pembelian_id);
        $pembelian->sisa = $pembelian->sisa + $limbah->jumlah;
        $pembelian->save();
        $barang = Barang::find($pembelian->master_item_id);
        $item = Item::find($barang->item_id);
        $item->stock = $item->stock + $limbah->jumlah;
        $item->save();

        $limbah->delete();
        return redirect()->route('studiolimbah.index')->with('success', 'menghapus limbah barang');
    }
}
