<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
// use App\Models\Penjualan;
use App\Models\Barang;
use App\Models\Item;
use App\Models\Pembelian;
use App\Models\Produk;
use App\Models\PenjualanProduk;
use App\Models\PenjualanProdukBarang;
use Illuminate\Database\Eloquent\Builder;
use Carbon\Carbon;

class StudioPenjualanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $produk = Produk::where('toko', '=', 'SGH_Studio')->get();

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
                    $query->where('toko', '=', 'SGH_Motor');
                });
        }])
        ->where('sisa', '>', 0)
        ->get();

        $penjualan = PenjualanProdukBarang::select('penjualan_produk_transaksi_pembelian.penjualan_produk_id')
            ->join('transaksi_pembelian', 'transaksi_pembelian.id', '=', 'penjualan_produk_transaksi_pembelian.transaksi_pembelian_id')
            ->join('master_item', 'master_item.id', '=', 'transaksi_pembelian.master_item_id')
            ->join('kategori', 'kategori.id', '=', 'master_item.kategori_id')
            ->join('penjualan_produk', 'penjualan_produk.id', '=', 'penjualan_produk_transaksi_pembelian.penjualan_produk_id')
            ->where('kategori.toko', '=', 'SGH_Studio')
            ->groupBy('penjualan_produk_transaksi_pembelian.penjualan_produk_id')
            ->orderBy('penjualan_produk.tanggal', 'desc')
            ->with(['penjualan_produk' => function ($query) {
                $query->with('produk');
            }])
        ->paginate(7);

        return view('studio.penjualan',
        [
            "produk" => $produk,
            "barang" => $barang,
            "pembelian" => $pembelian,
            "penjualan" => $penjualan,
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
            'customer' => 'required|max:255',
            'produk' => 'required|numeric',
            'namaDynamic.*' => 'required|numeric',
            'batchDynamic.*' => 'required|numeric',
            'jumlahDynamic.*' => 'required|numeric',
            'jprod' => 'required|numeric',
            'harga' => 'required|numeric',
            'tanggal' => 'required|max:255',
        ], [
            'customer.required' => 'Input customer tidak boleh kosong',
            'customer.max' => 'Input customer tidak boleh lebih dari 255 karakter',
            'produk.required' => 'Input produk tidak boleh kosong',
            'produk.numeric' => 'Input produk harus benar',
            'namahDynamic.*.required' => 'Input nama barang tidak boleh kosong',
            'namahDynamic.*.numeric' => 'Input nama barang harus benar',
            'batchDynamic.*.required' => 'Input batch barang tidak boleh kosong',
            'batchDynamic.*.numeric' => 'Input nama barang harus benar',
            'jumlahDynamic.*.required' => 'Input jumlah tidak boleh kosong',
            'jumlahDynamic.*.numeric' => 'Input jumlah harus nomor',
            'jprod.required' => 'Input harga tidak boleh kosong',
            'jprod.numeric' => 'Input harga harus nomor',
            'harga.required' => 'Input harga tidak boleh kosong',
            'harga.numeric' => 'Input harga harus nomor',
            'tanggal.required' => 'Input tanggal tidak boleh kosong',
            'tanggal.max' => 'Input tanggal tidak boleh lebih dari 255 karakter',
        ]);


        $namaDynamic = $request->input('namaDynamic', []);
        $batchDynamic = $request->input('batchDynamic', []);
        $jumlahDynamic = $request->input('jumlahDynamic', []);

        $selectedDate = $request->tanggal;

        // Convert the selected date to a timestamp (UNIX timestamp)
        $timestamp = Carbon::parse($selectedDate)->timestamp;

        $penjualan_produk = PenjualanProduk::create([
            'produk_id' => $request->produk,
            'nama' => $request->customer,
            'jumlah' => $request->jprod,
            'harga' => $request->harga,
            'tanggal' => $timestamp,
        ]);

        // Make sure both arrays have the same length
        $minLength = min(count($batchDynamic), count($jumlahDynamic), count($namaDynamic));

        for ($i = 0; $i < $minLength; $i++) {
            $batchValue = $batchDynamic[$i];
            $jumlahValue = $jumlahDynamic[$i];
            $itemId = $namaDynamic[$i];
            
            $item = Item::find($itemId);
            if (!$item) {
                // Handle case where the resource is not found
                abort(404, 'Resource not found');
            }
            $pembelian = Pembelian::find($batchValue);
            if (!$pembelian) {
                // Handle case where the resource is not found
                abort(404, 'Resource not found');
            }

            PenjualanProdukBarang::create([
                'transaksi_pembelian_id' => $batchValue,
                'penjualan_produk_id' => $penjualan_produk->id,
                'jumlah' => $jumlahValue
            ]);
            
            $item->stock = $item->stock - $jumlahValue;
            $item->save();

            $pembelian->sisa = $pembelian->sisa - $jumlahValue;
            $pembelian->save();
        }
        // return $batchDynamic;

        return redirect()->route('studiopenjualan.index')->with('success', 'menambahkan penjualan produk');
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
        $penjualan = PenjualanProdukBarang::where('penjualan_produk_id','=',$id)->get();
        if (!$penjualan) {
            // Handle case where the resource is not found
            abort(404, 'Resource not found');
        }

        foreach ($penjualan as $record) {
            $pembelian = Pembelian::find($record->transaksi_pembelian_id);
            $pembelian->sisa = $pembelian->sisa + $record->jumlah;
            $pembelian->save();
            $barang = Barang::find($pembelian->master_item_id);
            $item = Item::find($barang->item_id);
            $item->stock = $item->stock + $record->jumlah;
            $item->save();

            $record->delete();
        }

        $penjualan_produk = PenjualanProduk::find($id);
        $penjualan_produk->delete();

        return redirect()->route('studiopenjualan.index')->with('success', 'menghapus penjualan produk');
    }
}
