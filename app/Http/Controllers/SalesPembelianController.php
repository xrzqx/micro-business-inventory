<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Sales;
use App\Models\Item;
use App\Models\Barang;
use App\Models\SalesPembelian;
use App\Models\Pembelian;
use Illuminate\Database\Eloquent\Builder;
use Carbon\Carbon;

class SalesPembelianController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $sales = Sales::all();
        $barang = Barang::select('master_item.*')
            ->join('item', 'item.id', '=', 'master_item.item_id')
            ->join('kategori', 'kategori.id', '=', 'master_item.kategori_id')
            ->where('kategori.toko', '!=', 'SGH_Studio')
            ->where('kategori.toko', '!=', 'SGH_Motor')
            ->where('item.stock', '>', 0)
            ->with('item')
            ->get();

        $sales_pembelian = SalesPembelian::select('sales_pembelian.*')
            ->orderBy('sales_pembelian.tanggal', 'desc')
            ->with(['sales','pembelian' => function ($query) {
                $query->with(['barang' => function ($query) {
                    $query->with(['item']);
                }]);
            }])
            ->paginate(7);

        // return $sales_pembelian;

        // return $barang;
        return view("sales.pembelian",
        [
            "sales" => $sales,
            "barang" => $barang,
            "pembelian" => $sales_pembelian
            // "pembelian" => $pembelian,
        ]);
    }

    public function store(Request $request)
    {
        $validator =  $request->validate([
            'sales' => 'required|max:255',
            'nama' => 'required|numeric',
            'batch' => 'required|numeric',
            'jumlah' => 'required|numeric',
            'harga' => 'required|numeric',
            'tanggal' => 'required|max:255',
        ], [
            'sales.required' => 'Input sales tidak boleh kosong',
            'sales.max' => 'Input sales tidak boleh lebih dari 255 karakter',
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
        SalesPembelian::create([
            'sales_id' => $request->sales,
            'transaksi_pembelian_id' => $request->batch,
            'jumlah' => $request->jumlah,
            'sisa' => $request->jumlah,
            'harga' => $request->harga,
            'tanggal' => $timestamp,
        ]);

        $item->stock = $item->stock - $request->jumlah;
        $item->save();

        $pembelian = Pembelian::find($request->batch);
        $pembelian->sisa = $pembelian->sisa - $request->jumlah;
        $pembelian->save();

        return redirect()->route('salespembelian.index')->with('success', 'menambahkan pengambilan barang');
    }

    public function edit($id)
    {
        $sales_pembelian = SalesPembelian::find($id);
        if (!$sales_pembelian) {
            // Handle case where the resource is not found
            abort(404, 'Resource not found');
        }

        // $pembelianSelect = Pembelian::with(['barang' => function ($query) {
        //     $query->with('item', 'kategori')
        //         ->whereHas('kategori', function (Builder $query) {
        //             $query->where('toko', '=', 'SGH_Motor');
        //         });
        // }])
        // ->distinct('master_item_id')
        // ->where('sisa', '>', 0)
        // ->get(['master_item_id']);

        $pembelian = Pembelian::find($sales_pembelian->transaksi_pembelian_id);

        $barang = Barang::find($pembelian->master_item_id);
        // $item = Item::find($barang->item_id);
        return view('sales.pembelianedit', 
        [
            // "pembelianSelect" => $pembelianSelect,
            "barang" => $barang,
            "pembelian" => $pembelian,
            "penjualan" => $penjualan,
        ]);
    }

    public function destroy($id)
    {
        $sales_pembelian = SalesPembelian::find($id);
        if (!$sales_pembelian) {
            // Handle case where the resource is not found
            abort(404, 'Resource not found');
        }

        $pembelian = Pembelian::find($sales_pembelian->transaksi_pembelian_id);
        $pembelian->sisa = $pembelian->sisa + $sales_pembelian->jumlah;
        $pembelian->save();
        $barang = Barang::find($pembelian->master_item_id);
        $item = Item::find($barang->item_id);
        $item->stock = $item->stock + $sales_pembelian->jumlah;
        $item->save();

        $sales_pembelian->delete();
        return redirect()->route('salespembelian.index')->with('success', 'menghapus pembelian barang');
    }

    public function search(Request $request)
    {
        $searchQuery = $request->input('namabarang');

        $sales = Sales::all();
        $barang = Barang::select('master_item.*')
            ->join('item', 'item.id', '=', 'master_item.item_id')
            ->join('kategori', 'kategori.id', '=', 'master_item.kategori_id')
            ->where('kategori.toko', '!=', 'SGH_Studio')
            ->where('kategori.toko', '!=', 'SGH_Motor')
            ->where('item.stock', '>', 0)
            ->with('item')
            ->get();

        $sales_pembelian = SalesPembelian::select('sales_pembelian.*')
            ->join('transaksi_pembelian', 'transaksi_pembelian.id', '=', 'sales_pembelian.transaksi_pembelian_id')
            ->join('master_item', 'master_item.id', '=', 'transaksi_pembelian.master_item_id')
            ->join('kategori', 'kategori.id', '=', 'master_item.kategori_id')
            ->join('item', 'item.id', '=', 'master_item.item_id')
            ->where('kategori.toko', '!=', 'SGH_Studio')
            ->where('kategori.toko', '!=', 'SGH_Motor')
            ->where('item.nama', 'like', '%' . $searchQuery . '%')
            ->orderBy('sales_pembelian.tanggal', 'desc')
            ->distinct()
            ->with(['sales','pembelian' => function ($query) {
                $query->with(['barang' => function ($query) {
                    $query->with(['item']);
                }]);
            }])
            ->paginate(7);

        return view("sales.pembelian",
        [
            "sales" => $sales,
            "barang" => $barang,
            "pembelian" => $sales_pembelian,
        ]);
    }
}
