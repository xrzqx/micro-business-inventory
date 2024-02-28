<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Penjualan;
use App\Models\Item;
use App\Models\Pembelian;
use App\Models\Barang;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Builder;
use Carbon\Carbon;

class PupukPenjualanController extends Controller
{
    //
    public function index(){

        $barang = Pembelian::select('transaksi_pembelian.master_item_id')
            ->join('master_item', 'master_item.id', '=', 'transaksi_pembelian.master_item_id')
            ->join('kategori', 'kategori.id', '=', 'master_item.kategori_id')
            ->join('item', 'item.id', '=', 'master_item.item_id')
            ->where('kategori.toko', '=', 'pupuk')
            ->where('sisa', '>', 0)
            ->groupBy('transaksi_pembelian.master_item_id')
            ->with(['barang' => function ($query) {
                $query->with('item', 'kategori');
            }])
            ->get();

        // return $barang;
        
        // return $pembelian;
        $pembelian = Pembelian::with(['barang' => function ($query) {
            $query->with('item', 'kategori')
                ->whereHas('kategori', function (Builder $query) {
                    $query->where('toko', '=', 'pupuk');
                });
        }])
        ->where('sisa', '>', 0)
        ->get();

        $penjualan = Penjualan::select('transaksi_penjualan.*')
            ->join('transaksi_pembelian', 'transaksi_pembelian.id', '=', 'transaksi_penjualan.transaksi_pembelian_id')
            ->join('master_item', 'master_item.id', '=', 'transaksi_pembelian.master_item_id')
            ->join('kategori', 'kategori.id', '=', 'master_item.kategori_id')
            // ->join('item', 'item.id', '=', 'master_item.item_id')
            ->where('kategori.toko', '=', 'pupuk')
            // ->groupBy('transaksi_pembelian.master_item_id')
            ->orderBy('transaksi_penjualan.tanggal', 'desc')
            ->with(['pembelian' => function ($query) {
                $query->with(['barang' => function ($query) {
                    $query->with(['item', 'kategori']);
                }]);
            }])
            ->orderBy('transaksi_penjualan.tanggal', 'desc')
            ->paginate(7);

        return view('pupuk.penjualan',
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
            'cod' => 'nullable|numeric',
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
            'cod.numeric' => 'Input harga harus nomor',
            'tanggal.required' => 'Input tanggal tidak boleh kosong',
            'tanggal.max' => 'Input tanggal tidak boleh lebih dari 255 karakter',
        ]);

        $selectedDate = $request->tanggal;

        // Convert the selected date to a timestamp (UNIX timestamp)
        $timestamp = Carbon::parse($selectedDate)->timestamp;

        $barang = Barang::find($request->nama);
        $item = Item::find($barang->item_id);
        // return $item;
        $total_harga = $request->jumlah * $request->harga;
        // $cod = 0;
        // if ($request->cod) {
        //     $cod = $request->cod;
        // }

        Penjualan::create([
            'transaksi_pembelian_id' => $request->batch,
            'nama' => $request->customer,
            'jumlah' => $request->jumlah,
            'harga' => $total_harga,
            'cod' => $request->cod,
            'tanggal' => $timestamp,
        ]);

        $item->stock = $item->stock - $request->jumlah;
        $item->save();

        $pembelian = Pembelian::find($request->batch);
        $pembelian->sisa = $pembelian->sisa - $request->jumlah;
        $pembelian->save();

        return redirect()->route('pupukpenjualan.index')->with('success', 'menambahkan penjualan barang');
    }

    public function edit($id)
    {
        $penjualan = Penjualan::find($id);
        if (!$penjualan) {
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

        $pembelian = Pembelian::find($penjualan->transaksi_pembelian_id);

        $barang = Barang::find($pembelian->master_item_id);
        // $item = Item::find($barang->item_id);
        return view('pupuk.penjualanedit', 
        [
            // "pembelianSelect" => $pembelianSelect,
            "barang" => $barang,
            "pembelian" => $pembelian,
            "penjualan" => $penjualan,
        ]);
    }

    public function destroy($id)
    {
        
        DB::beginTransaction();
        try {
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

            // If everything went well, commit the transaction
            DB::commit();
        } catch (\Exception $e) {
            // If an exception occurs, rollback the transaction
            DB::rollBack();

            // Handle the exception or log it as needed
            return response()->json(['error' => 'Transaction failed.'], 500);
        }

        return redirect()->route('pupukpenjualan.index')->with('success', 'menghapus penjualan barang');
    }

    public function search(Request $request)
    {
        $searchQuery = $request->input('namabarang');
        
        $barang = Pembelian::select('transaksi_pembelian.master_item_id')
            ->join('master_item', 'master_item.id', '=', 'transaksi_pembelian.master_item_id')
            ->join('kategori', 'kategori.id', '=', 'master_item.kategori_id')
            ->join('item', 'item.id', '=', 'master_item.item_id')
            ->where('kategori.toko', '=', 'pupuk')
            ->where('sisa', '>', 0)
            ->groupBy('transaksi_pembelian.master_item_id')
            ->with(['barang' => function ($query) {
                $query->with('item', 'kategori');
            }])
            ->get();

        $penjualan = Penjualan::select('transaksi_penjualan.*')
            ->join('transaksi_pembelian', 'transaksi_pembelian.id', '=', 'transaksi_penjualan.transaksi_pembelian_id')
            ->join('master_item', 'master_item.id', '=', 'transaksi_pembelian.master_item_id')
            ->join('kategori', 'kategori.id', '=', 'master_item.kategori_id')
            ->join('item', 'item.id', '=', 'master_item.item_id')
            ->where('kategori.toko', '=', 'pupuk')
            ->where('item.nama', 'like', '%' . $searchQuery . '%')
            ->distinct()
            ->with(['pembelian' => function ($query) use ($searchQuery){
                $query->with(['barang' => function ($query) {
                    $query->with('item');
                }]);
            }])
            ->paginate(7);

        // return $penjualan;

        return view("pupuk.penjualan",
        [
            "barang" => $barang,
            "penjualan" => $penjualan,
        ]);
    }
}