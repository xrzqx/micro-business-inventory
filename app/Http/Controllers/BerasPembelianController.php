<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Barang;
use App\Models\Item;
use App\Models\Kategori;
use App\Models\Pembelian;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class BerasPembelianController extends Controller
{
    //
    public function index(){
        $barang = Barang::with('item', 'kategori')
        ->whereHas('kategori', function (Builder $query) {
            $query->where('toko', '=', 'beras');
        })
        ->get();

        $pembelian = Pembelian::select('transaksi_pembelian.*')
            ->join('master_item', 'master_item.id', '=', 'transaksi_pembelian.master_item_id')
            ->join('kategori', 'kategori.id', '=', 'master_item.kategori_id')
            ->join('item', 'item.id', '=', 'master_item.item_id')
            ->where('kategori.toko', '=', 'beras')
            ->with(['barang' => function ($query) {
                $query->with('item', 'kategori');
            }])
            ->paginate(7);

        return view("beras.pembelian",
        [
            "barang" => $barang,
            "pembelian" => $pembelian,
        ]);
    }

    public function store(Request $request)
    {
        $validator =  $request->validate([
            'supplier' => 'required|max:255',
            'nama' => 'required|numeric',
            'batch' => 'required|max:255',
            'jumlah' => 'required|numeric',
            'harga' => 'required|numeric',
            'tanggal' => 'required|max:255',
        ], [
            'supplier.required' => 'Input supplier tidak boleh kosong',
            'supplier.max' => 'Input supplier tidak boleh lebih dari 255 karakter',
            'nama.required' => 'Input nama barang tidak boleh kosong',
            'nama.numeric' => 'Input nama barang harus benar',
            'batch.required' => 'Input batch barang tidak boleh kosong',
            'batch.max' => 'Input batch barang tidak boleh lebih dari 255 karakter',
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
        Pembelian::create([
            'master_item_id' => $request->nama,
            'supplier' => $request->supplier,
            'batch' => $request->batch,
            'jumlah' => $request->jumlah,
            'sisa' => $request->jumlah,
            'harga' => $request->harga,
            // 'tanggal' => $request->tanggal,
            'tanggal' => $timestamp,
        ]);

        $item->stock = $item->stock + $request->jumlah;
        $item->save();

        return redirect()->route('beraspembelian.index')->with('success', 'menambahkan pembelian barang');
    }

    public function edit($id)
    {
        $barang = Barang::with('item', 'kategori')
            ->whereHas('kategori', function (Builder $query) {
                $query->where('toko', '=', 'beras');
            })
            ->get();
        
        $pembelian = Pembelian::with(['barang' => function ($query) {
            $query->with('item', 'kategori')
                ->whereHas('kategori', function (Builder $query) {
                    $query->where('toko', '=', 'beras');
                });
            }])
            ->where('id', $id)
            ->get();
        
        if (!$pembelian) {
            // Handle case where the resource is not found
            abort(404, 'Resource not found');
        }
        return view('beras.pembelianedit', 
        [
            "barang" => $barang,
            "pembelian" => $pembelian,
        ]);
    }

    public function update(Request $request, $id)
    {
        $validator =  $request->validate([
            'supplier' => 'required|max:255',
            'nama' => 'required|numeric',
            'batch' => 'required|max:255',
            'jumlah' => 'required|numeric',
            'harga' => 'required|numeric',
            'tanggal' => 'required|max:255',
        ], [
            'supplier.required' => 'Input supplier tidak boleh kosong',
            'supplier.max' => 'Input supplier tidak boleh lebih dari 255 karakter',
            'nama.required' => 'Input nama barang tidak boleh kosong',
            'nama.numeric' => 'Input nama barang harus benar',
            'batch.required' => 'Input batch barang tidak boleh kosong',
            'batch.max' => 'Input batch barang tidak boleh lebih dari 255 karakter',
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

        $pembelian = Pembelian::find($id);
        if (!$pembelian) {
            // Handle case where the resource is not found
            abort(404, 'Resource not found');
        }

        $barang = Barang::find($request->nama);
        $item = Item::find($barang->item_id);

        if ($pembelian->jumlah > $request->jumlah) {
            $selisih = $pembelian->jumlah - $request->jumlah;
            $item->stock = $item->stock - $selisih;
            $pembelian->sisa = $pembelian->sisa - $selisih;
            $pembelian->jumlah = $pembelian->jumlah - $selisih;
        }
        elseif ($pembelian->jumlah < $request->jumlah) {
            $selisih = $request->jumlah - $pembelian->jumlah;
            $item->stock = $item->stock + $selisih;
            $pembelian->sisa = $pembelian->sisa + $selisih;
            $pembelian->jumlah = $pembelian->jumlah + $selisih;
        }
        $item->save();
        $pembelian->supplier = $request->supplier;
        $pembelian->master_item_id = $request->nama;
        $pembelian->batch = $request->batch;
        $pembelian->harga = $request->harga;
        $pembelian->tanggal = $timestamp;
        $pembelian->save();

        return redirect()->route('beraspembelian.index')->with('success', 'mengedit pembelian barang');
    }

    public function destroy($id)
    {

        DB::beginTransaction();

        try {
            $pembelian = Pembelian::find($id);
            if (!$pembelian) {
                // Handle case where the resource is not found
                abort(404, 'Resource not found');
            }
            $barang = Barang::find($pembelian->master_item_id);
            $item = Item::find($barang->item_id);
            $item->stock = $item->stock - $pembelian->jumlah;
            $item->save();
    
            $pembelian->delete();

            // If everything went well, commit the transaction
            DB::commit();
        } catch (\Exception $e) {
            // If an exception occurs, rollback the transaction
            DB::rollBack();

            // Handle the exception or log it as needed
            return response()->json(['error' => 'Transaction failed.'], 500);
        }

        return redirect()->route('beraspembelian.index')->with('success', 'menghapus pembelian barang');
    }

    public function search(Request $request)
    {
        $searchQuery = $request->input('namabarang');
        
        $barang = Barang::with('item', 'kategori')
        ->whereHas('kategori', function (Builder $query) {
            $query->where('toko', '=', 'beras');
        })
        ->get();

        $pembelian = Pembelian::select('transaksi_pembelian.*')
        ->join('master_item', 'master_item.id', '=', 'transaksi_pembelian.master_item_id')
        ->join('kategori', 'kategori.id', '=', 'master_item.kategori_id')
        ->join('item', 'item.id', '=', 'master_item.item_id')
        ->where('kategori.toko', '=', 'beras')
        ->where('item.nama', 'like', '%' . $searchQuery . '%')
        ->distinct()
        ->with(['barang' => function ($query) use ($searchQuery){
            $query->with('item');
        }])
        ->paginate(7);


        return view("beras.pembelian",
        [
            "barang" => $barang,
            "pembelian" => $pembelian,
        ]);
    }
}
