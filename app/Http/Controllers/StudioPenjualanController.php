<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Barang;
use App\Models\Item;
use App\Models\Pembelian;
use App\Models\Produk;
use App\Models\PenjualanProduk;
use App\Models\PenjualanProdukBarang;
use App\Models\Customer;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;
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
                $query->with(['produk','customer']);
            }])
        ->paginate(7);
        // return $penjualan;

        $customer = Customer::select(['customer.id','customer.nama','customer.nomor'])->where("module","SGH_Studio")->get();

        return view('studio.penjualan',
        [
            "produk" => $produk,
            "barang" => $barang,
            "pembelian" => $pembelian,
            "penjualan" => $penjualan,
            "customer" => $customer,
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
            'customer' => 'required|numeric',
            'produk' => 'required|numeric',
            'namaDynamic.*' => 'required|numeric',
            'batchDynamic.*' => 'required|numeric',
            'jumlahDynamic.*' => 'required|numeric',
            'jprod' => 'required|numeric',
            'harga' => 'required|numeric',
            'tanggal' => 'required|max:255',
            'kategori' => 'nullable|max:100'
        ], [
            'customer.required' => 'Input customer tidak boleh kosong',
            'customer.numeric' => 'Input nama customer harus benar',
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
            'kategori.max' => 'Input kategori tidak boleh lebih dari 100 karakter',
        ]);


        $namaDynamic = $request->input('namaDynamic', []);
        $batchDynamic = $request->input('batchDynamic', []);
        $jumlahDynamic = $request->input('jumlahDynamic', []);

        $selectedDate = $request->tanggal;

        // Convert the selected date to a timestamp (UNIX timestamp)
        $timestamp = Carbon::parse($selectedDate)->timestamp;

        $penjualan_produk = PenjualanProduk::create([
            'produk_id' => $request->produk,
            // 'nama' => $request->customer,
            'customer_id' => $request->customer,
            'jumlah' => $request->jprod,
            'harga' => $request->harga,
            'tanggal' => $timestamp,
            'keterangan' => $request->keterangan,
        ]);

        // Make sure both arrays have the same length
        $minLength = min(count($batchDynamic), count($jumlahDynamic), count($namaDynamic));

        for ($i = 0; $i < $minLength; $i++) {
            $batchValue = $batchDynamic[$i];
            $jumlahValue = $jumlahDynamic[$i];
            $barangId = $namaDynamic[$i];

            $barang = Barang::find($barangId);
            
            $item = Item::find($barang->item_id);
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

        return redirect()->route('studiopenjualan.index')->with('success', 'berhasil menambahkan penjualan produk');
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
        $penjualan = PenjualanProduk::find($id);
        if (!$penjualan) {
            // Handle case where the resource is not found
            abort(404, 'Resource not found');
        }

        $produk = Produk::where('toko', '=', 'SGH_Studio')->get();

        $barang = Pembelian::select('transaksi_pembelian.master_item_id')
            ->join('master_item', 'master_item.id', '=', 'transaksi_pembelian.master_item_id')
            ->join('kategori', 'kategori.id', '=', 'master_item.kategori_id')
            ->join('item', 'item.id', '=', 'master_item.item_id')
            ->where('kategori.toko', '=', 'SGH_Studio')
            ->groupBy('transaksi_pembelian.master_item_id')
            ->with(['barang' => function ($query) {
                $query->with('item', 'kategori');
            }])
            ->get();

        $kertas = PenjualanProdukBarang::select('penjualan_produk_transaksi_pembelian.*')
            ->where('penjualan_produk_transaksi_pembelian.penjualan_produk_id',$id)
            ->with('pembelian')
            ->get();

        $kertas_list = Pembelian::select(['transaksi_pembelian.id','transaksi_pembelian.master_item_id','transaksi_pembelian.batch','transaksi_pembelian.sisa','transaksi_pembelian.jumlah'])
            ->join('master_item', 'master_item.id', '=', 'transaksi_pembelian.master_item_id')
            ->join('kategori', 'kategori.id', '=', 'master_item.kategori_id')
            ->join('item', 'item.id', '=', 'master_item.item_id')
            ->where('kategori.toko', '=', 'SGH_Studio')
            ->get();

        $customer = Customer::select(['customer.id','customer.nama','customer.nomor'])->where("module","SGH_Studio")->get();

        // return $penjualan;

        return view('studio.penjualanedit',[
            'penjualan' => $penjualan,
            "produk" => $produk,
            "barang" => $barang,
            "kertas" => $kertas,
            "kertas_list" => $kertas_list,
            "customer" => $customer
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
        $validator =  $request->validate([
            'customer' => 'required|numeric',
            'produk' => 'required|numeric',
            'namaDynamic.*' => 'required|numeric',
            'batchDynamic.*' => 'required|numeric',
            'jumlahDynamic.*' => 'required|numeric',
            'jprod' => 'required|numeric',
            'harga' => 'required|numeric',
            'tanggal' => 'required|max:255',
            'kategori' => 'nullable|max:100'
        ], [
            'customer.required' => 'Input customer tidak boleh kosong',
            'customer.numeric' => 'Input nama customer harus benar',
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
            'kategori.max' => 'Input kategori tidak boleh lebih dari 100 karakter',
        ]);

        $idDynamic = $request->input('itemDynamic', []);
        $namaDynamic = $request->input('namaDynamic', []);
        $batchDynamic = $request->input('batchDynamic', []);
        $jumlahDynamic = $request->input('jumlahDynamic', []);

        $selectedDate = $request->tanggal;

        // Convert the selected date to a timestamp (UNIX timestamp)
        $timestamp = Carbon::parse($selectedDate)->timestamp;

        $penjualan_produk = PenjualanProduk::find($id);
        if (!$penjualan_produk) {
            // Handle case where the resource is not found
            abort(404, 'Resource not found');
        }

        DB::beginTransaction();
        try {
            $penjualan_produk->produk_id = $request->produk;
            $penjualan_produk->customer_id = $request->customer;
            $penjualan_produk->jumlah = $request->jprod;
            $penjualan_produk->harga = $request->harga;
            $penjualan_produk->tanggal = $timestamp;
            $penjualan_produk->keterangan = $request->keterangan;
            $penjualan_produk->save();
            // If everything went well, commit the transaction
            DB::commit();
        } catch (\Exception $e) {
            // If an exception occurs, rollback the transaction
            DB::rollBack();
        
            // Handle the exception or log it as needed
            return response()->json(['error' => 'Transaction failed.'], 500);
        }

        // Make sure both arrays have the same length
        $minLength = min(count($batchDynamic), count($jumlahDynamic), count($namaDynamic));

        for ($i = 0; $i < $minLength; $i++) {
            $invoiceItemId = $idDynamic[$i];
            $batchValue = $batchDynamic[$i];
            $jumlahValue = $jumlahDynamic[$i];
            $barangId = $namaDynamic[$i];

            $barang = Barang::find($barangId);
            
            $item = Item::find($barang->item_id);
            if (!$item) {
                // Handle case where the resource is not found
                abort(404, 'Resource not found');
            }
            $pembelian = Pembelian::find($batchValue);
            if (!$pembelian) {
                // Handle case where the resource is not found
                abort(404, 'Resource not found');
            }

            $penjualan_produk_barang = PenjualanProdukBarang::find($invoiceItemId);
                if (!$penjualan_produk_barang) {
                    // Handle case where the resource is not found
                    abort(404, 'Resource not found');
                }
            // return $penjualan_produk_barang;
            
            if ($penjualan_produk_barang->jumlah > $jumlahValue) {
                DB::beginTransaction();
                try {
                    $selisih = $penjualan_produk_barang->jumlah - $jumlahValue;
                    $item->stock = $item->stock + $selisih;
                    $item->save();
                    $pembelian->sisa = $pembelian->sisa + $selisih;
                    $pembelian->save();
                    $penjualan_produk_barang->jumlah = $penjualan_produk_barang->jumlah - $selisih;
                    $penjualan_produk_barang->save();
                    DB::commit();
                } catch (\Exception $e) {
                    // If an exception occurs, rollback the transaction
                    DB::rollBack();
                
                    // Handle the exception or log it as needed
                    return response()->json(['error' => 'Transaction failed.'], 500);
                }
            }
            if ($penjualan_produk_barang->jumlah < $jumlahValue) {
                DB::beginTransaction();
                try {
                    $selisih = $jumlahValue - $penjualan_produk_barang->jumlah;
                    $item->stock = $item->stock - $selisih;
                    $item->save();
                    $pembelian->sisa = $pembelian->sisa - $selisih;
                    $pembelian->save();
                    $penjualan_produk_barang->jumlah = $penjualan_produk_barang->jumlah + $selisih;
                    $penjualan_produk_barang->save();
                    DB::commit();
                } catch (\Exception $e) {
                    // If an exception occurs, rollback the transaction
                    DB::rollBack();
                
                    // Handle the exception or log it as needed
                    return response()->json(['error' => 'Transaction failed.'], 500);
                }
            }
        }

        return redirect()->route('studiopenjualan.index')->with('success', 'berhasil mengedit penjualan produk');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        DB::beginTransaction();

        try {
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
        
            // If everything went well, commit the transaction
            DB::commit();
        } catch (\Exception $e) {
            // If an exception occurs, rollback the transaction
            DB::rollBack();
        
            // Handle the exception or log it as needed
            return response()->json(['error' => 'Transaction failed.'], 500);
        }


        return redirect()->route('studiopenjualan.index')->with('success', 'menghapus penjualan produk');
    }

    public function search(Request $request)
    {
        //
        $searchStart = $request->input('start');
        $searchEnd = $request->input('end');
        if (!$searchEnd) {
            $currentTimestamp = Carbon::now();
            $searchEnd = $currentTimestamp->format('d-m-Y');
        }
        if (!$searchStart) {
            $timestampMinTx = PenjualanProduk::select(\DB::raw('min(penjualan_produk.tanggal) as tanggal'))->first();
            $dateTx = Carbon::createFromTimestamp($timestampMinTx);
            $searchStart = $dateTx->format('d-m-Y');
        }
        $timestampStart = Carbon::parse($searchStart)->timestamp;
        $timestampEnd = Carbon::parse($searchEnd)->timestamp;

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
            ->join('customer', 'customer.id', '=', 'penjualan_produk.customer_id')
            ->where('kategori.toko', '=', 'SGH_Studio')
            ->where('penjualan_produk.tanggal', '>=', $timestampStart)
            ->where('penjualan_produk.tanggal', '<=', $timestampEnd)
            ->groupBy('penjualan_produk_transaksi_pembelian.penjualan_produk_id')
            ->orderBy('penjualan_produk.tanggal', 'desc')
            ->with(['penjualan_produk' => function ($query) {
                $query->with(['produk','customer']);
            }])
        ->paginate(7);
        // return $penjualan;

        $customer = Customer::select(['customer.id','customer.nama','customer.nomor'])->where("module","SGH_Studio")->get();

        return view('studio.penjualan',
        [
            "produk" => $produk,
            "barang" => $barang,
            "pembelian" => $pembelian,
            "penjualan" => $penjualan,
            "customer" => $customer,
        ]);
    }
}
