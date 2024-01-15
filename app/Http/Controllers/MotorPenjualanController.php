<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Penjualan;
use App\Models\Item;
use App\Models\Pembelian;
use App\Models\Barang;
use Illuminate\Database\Eloquent\Builder;
use Carbon\Carbon;

class MotorPenjualanController extends Controller
{
    //
    public function index(){
        // $item = Item::all();
        $barang = Pembelian::with(['barang' => function ($query) {
            $query->with('item', 'kategori')
                ->whereHas('kategori', function (Builder $query) {
                    $query->where('toko', '=', 'SGH_Motor');
                });
        }])
        ->distinct('master_item_id')
        ->where('sisa', '>', 0)
        ->get(['master_item_id']);
        // ->get();
        
        // return $pembelian;
        $pembelian = Pembelian::with(['barang' => function ($query) {
            $query->with('item', 'kategori')
                ->whereHas('kategori', function (Builder $query) {
                    $query->where('toko', '=', 'SGH_Motor');
                });
        }])
        ->where('sisa', '>', 0)
        ->get();

        // $penjualan = Penjualan::with('pembelian')->get();
        $penjualan = Penjualan::with(['pembelian' => function ($query) {
            $query->with(['barang' => function ($query) {
                $query->with(['item', 'kategori'])
                    ->whereHas('kategori', function ($query) {
                        $query->where('toko', '=', 'SGH_Motor');
                    });
            }]);
        }])
        ->paginate(7);
        return view('motor.penjualan',
        [
            "barang" => $barang,
            "pembelian" => $pembelian,
            "penjualan" => $penjualan,
            // "item" => $item,
        ]);
    }

    public function store(Request $request)
    {
        $validator =  $request->validate([
            'customer' => 'required|max:255',
            'nama' => 'required|numeric',
            'batch' => 'required|numeric',
            'jumlah' => 'required|numeric',
            'harga' => 'required|numeric',
            'tanggal' => 'required|max:255',
        ], [
            'customer.required' => 'Input customer tidak boleh kosong',
            'customer.max' => 'Input customer tidak boleh lebih dari 255 karakter',
            'nama.required' => 'Input nama barang tidak boleh kosong',
            'nama.numeric' => 'Input nama barang harus benar',
            'batch.required' => 'Input batch barang tidak boleh kosong',
            'batch.numeric' => 'Input nama barang harus benar',
            'jumlah.required' => 'Input jumlah tidak boleh kosong',
            'jumlah.numeric' => 'Input jumlah harus nomor',
            'harga.required' => 'Input harga tidak boleh kosong',
            'harga.numeric' => 'Input harga harus nomor',
            'tanggal.required' => 'Input tanggal tidak boleh kosong',
            'tanggal.max' => 'Input tanggal tidak boleh lebih dari 255 karakter',
        ]);

        $selectedDate = $request->tanggal;

        // Convert the selected date to a timestamp (UNIX timestamp)
        $timestamp = Carbon::parse($selectedDate)->timestamp;

        $barang = Barang::find($request->nama);
        $item = Item::find($barang->item_id);
        // return $item;
        Penjualan::create([
            'transaksi_pembelian_id' => $request->batch,
            'nama' => $request->customer,
            'jumlah' => $request->jumlah,
            'harga' => $request->harga,
            'tanggal' => $timestamp,
        ]);

        $item->stock = $item->stock - $request->jumlah;
        $item->save();

        $pembelian = Pembelian::find($request->batch);
        $pembelian->sisa = $pembelian->sisa - $request->jumlah;
        $pembelian->save();

        return redirect()->route('motorpenjualan.index')->with('success', 'menambahkan penjualan barang');
    }

    public function edit($id)
    {
        $penjualan = Penjualan::find($id);
        if (!$penjualan) {
            // Handle case where the resource is not found
            abort(404, 'Resource not found');
        }

        $pembelianSelect = Pembelian::with(['barang' => function ($query) {
            $query->with('item', 'kategori')
                ->whereHas('kategori', function (Builder $query) {
                    $query->where('toko', '=', 'SGH_Motor');
                });
        }])
        ->distinct('master_item_id')
        ->where('sisa', '>', 0)
        ->get(['master_item_id']);

        $pembelian = Pembelian::find($penjualan->transaksi_pembelian_id);

        $barang = Barang::find($pembelian->master_item_id);
        // $item = Item::find($barang->item_id);
        return view('motor.penjualanedit', 
        [
            "pembelianSelect" => $pembelianSelect,
            "barang" => $barang,
            "pembelian" => $pembelian,
            "penjualan" => $penjualan,
        ]);
    }

    public function destroy($id)
    {
        $penjualan = Penjualan::find($id);
        if (!$penjualan) {
            // Handle case where the resource is not found
            abort(404, 'Resource not found');
        }

        $pembelian = Pembelian::find($penjualan->transaksi_pembelian_id);
        $pembelian->sisa = $pembelian->sisa + $penjualan->jumlah;
        $pembelian->save();
        $barang = Barang::find($pembelian->master_item_id);
        $item = Item::find($barang->item_id);
        $item->stock = $item->stock + $penjualan->jumlah;
        $item->save();

        $penjualan->delete();
        return redirect()->route('motorpenjualan.index')->with('success', 'menghapus penjualan barang');
    }
}
