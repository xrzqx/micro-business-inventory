<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Penjualan;
use App\Models\Item;
use App\Models\Pembelian;
use App\Models\Barang;
use App\Models\Customer;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class BerasPenjualanController extends Controller
{
    //
    public function index(){

        $barang = Pembelian::select('transaksi_pembelian.master_item_id')
            ->join('master_item', 'master_item.id', '=', 'transaksi_pembelian.master_item_id')
            ->join('kategori', 'kategori.id', '=', 'master_item.kategori_id')
            ->join('item', 'item.id', '=', 'master_item.item_id')
            ->where('kategori.toko', '=', 'beras')
            ->where('sisa', '>', 0)
            ->groupBy('transaksi_pembelian.master_item_id')
            ->with(['barang' => function ($query) {
                $query->with('item', 'kategori');
            }])
            ->get();

        $pembelian = Pembelian::with(['barang' => function ($query) {
            $query->with('item', 'kategori')
                ->whereHas('kategori', function (Builder $query) {
                    $query->where('toko', '=', 'beras');
                });
        }])
        ->where('sisa', '>', 0)
        ->get();

        $penjualan = Penjualan::select('transaksi_penjualan.*')
            ->join('transaksi_pembelian', 'transaksi_pembelian.id', '=', 'transaksi_penjualan.transaksi_pembelian_id')
            ->join('master_item', 'master_item.id', '=', 'transaksi_pembelian.master_item_id')
            ->join('kategori', 'kategori.id', '=', 'master_item.kategori_id')
            // ->join('item', 'item.id', '=', 'master_item.item_id')
            ->where('kategori.toko', '=', 'beras')
            // ->groupBy('transaksi_pembelian.master_item_id')
            ->orderBy('transaksi_penjualan.tanggal', 'desc')
            ->with(['pembelian' => function ($query) {
                $query->with(['barang' => function ($query) {
                    $query->with(['item', 'kategori']);
                }]);
            }])
            ->paginate(7);

        $customer = Customer::select(['customer.id','customer.nama'])->where("module","beras")->get();

        return view('beras.penjualan',
        [
            "barang" => $barang,
            "pembelian" => $pembelian,
            "penjualan" => $penjualan,
            "customer" => $customer,
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
            'customer_id' => $request->customer,
            'jumlah' => $request->jumlah,
            'harga' => $request->harga,
            'tanggal' => $timestamp,
        ]);

        $item->stock = $item->stock - $request->jumlah;
        $item->save();

        $pembelian = Pembelian::find($request->batch);
        $pembelian->sisa = $pembelian->sisa - $request->jumlah;
        $pembelian->save();

        return redirect()->route('beraspenjualan.index')->with('success', 'menambahkan penjualan barang');
    }

    public function edit($id)
    {
        $penjualan = Penjualan::find($id);
        if (!$penjualan) {
            // Handle case where the resource is not found
            abort(404, 'Resource not found');
        }

        $pembelian = Pembelian::find($penjualan->transaksi_pembelian_id);

        $barang = Pembelian::select('transaksi_pembelian.master_item_id')
            ->join('master_item', 'master_item.id', '=', 'transaksi_pembelian.master_item_id')
            ->join('kategori', 'kategori.id', '=', 'master_item.kategori_id')
            ->join('item', 'item.id', '=', 'master_item.item_id')
            ->where('kategori.toko', '=', 'beras')
            // ->where('sisa', '>', 0)
            ->groupBy('transaksi_pembelian.master_item_id')
            ->with(['barang' => function ($query) {
                $query->with('item', 'kategori');
            }])
            ->get();
        
        $customer = Customer::select(['customer.id','customer.nama'])->where("module","beras")->get();

        return view('beras.penjualanedit', 
        [
            "barang" => $barang,
            "pembelian" => $pembelian,
            "penjualan" => $penjualan,
            "customer" => $customer,
        ]);
    }

    public function update(Request $request, $id)
    {
        $validator =  $request->validate([
            'customer' => 'required|numeric',
            'nama' => 'required|numeric',
            'batch' => 'required|numeric',
            'jumlah' => 'required|numeric',
            'harga' => 'required|numeric',
            'tanggal' => 'required|max:255',
        ], [
            'customer.required' => 'Input customer tidak boleh kosong',
            'customer.numeric' => 'Input nama customer harus benar',
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

        $penjualan = Penjualan::find($id);
        if (!$penjualan) {
            // Handle case where the resource is not found
            abort(404, 'Resource not found');
        }
        if ($penjualan->transaksi_pembelian_id != $request->batch) {
            $pembelian = Pembelian::find($penjualan->transaksi_pembelian_id);
            $barang = Barang::find($pembelian->master_item_id);
            $item = Item::find($barang->item_id);

            $item->stock = $item->stock + $penjualan->jumlah;
            $pembelian->sisa = $pembelian->sisa + $penjualan->jumlah;
            $item->save();
            $pembelian->save();

            $penjualan->transaksi_pembelian_id = $request->batch;
            $penjualan->jumlah = $request->jumlah;
            $pembelian_selected = Pembelian::find($penjualan->transaksi_pembelian_id);
            $pembelian_selected->sisa = $pembelian_selected->sisa - $request->jumlah;
            $barang_selected = Barang::find($pembelian_selected->master_item_id);
            $item_selected = Item::find($barang_selected->item_id);
            $item_selected->stock = $item_selected->stock - $request->jumlah;
            $item_selected->save();
            $pembelian_selected->save();
        }
        else{
            if ($penjualan->transaksi_pembelian_id == $request->batch) {
                $pembelian = Pembelian::find($penjualan->transaksi_pembelian_id);
                $barang = Barang::find($pembelian->master_item_id);
                $item = Item::find($barang->item_id);
                if ($penjualan->jumlah > $request->jumlah) {
                    $selish = $penjualan->jumlah - $request->jumlah;
                    $penjualan->jumlah = $penjualan->jumlah - $selish;
                    $pembelian->sisa = $pembelian->sisa + $selish;
                    $item->stock = $item->stock + $selish;
                }
                if ($penjualan->jumlah < $request->jumlah) {
                    $selish = $request->jumlah - $penjualan->jumlah;
                    $penjualan->jumlah = $penjualan->jumlah + $selish;
                    $pembelian->sisa = $pembelian->sisa - $selish;
                    $item->stock = $item->stock - $selish;
                }
                $pembelian->save();
                $item->save();
            }
        }
        $penjualan->customer_id = $request->customer;
        $penjualan->harga = $request->harga;
        $penjualan->tanggal = $timestamp;
        $penjualan->save();
        
        return redirect()->route('beraspenjualan.index')->with('success', 'mengubah penjualan barang');
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

        return redirect()->route('beraspenjualan.index')->with('success', 'menghapus penjualan barang');
    }

    public function search(Request $request)
    {
        $searchQuery = $request->input('namabarang');
        
        $barang = Pembelian::select('transaksi_pembelian.master_item_id')
            ->join('master_item', 'master_item.id', '=', 'transaksi_pembelian.master_item_id')
            ->join('kategori', 'kategori.id', '=', 'master_item.kategori_id')
            ->join('item', 'item.id', '=', 'master_item.item_id')
            ->where('kategori.toko', '=', 'beras')
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
            ->where('kategori.toko', '=', 'beras')
            ->where('item.nama', 'like', '%' . $searchQuery . '%')
            ->distinct()
            ->with(['pembelian' => function ($query) use ($searchQuery){
                $query->with(['barang' => function ($query) {
                    $query->with('item');
                }]);
            }])
            ->paginate(7);

        // return $penjualan;

        return view("beras.penjualan",
        [
            "barang" => $barang,
            "penjualan" => $penjualan,
        ]);
    }
}
