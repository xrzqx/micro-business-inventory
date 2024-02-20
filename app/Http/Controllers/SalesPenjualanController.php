<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Sales;
use App\Models\SalesPenjualan;
use App\Models\SalesPembelian;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class SalesPenjualanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $sales = Sales::all();

        $sales_penjualan = SalesPenjualan::select('sales_penjualan.*')
            ->orderBy('sales_penjualan.tanggal', 'desc')
            ->with(['sales_pembelian' => function ($query) {
                $query->with(['sales','pembelian' => function ($query) {
                    $query->with(['barang' => function ($query) {
                        $query->with(['item']);
                    }]);
                }]);
                
            }])
            ->paginate(7);

        return view("sales.penjualan",
        [
            "sales" => $sales,
            "penjualan" => $sales_penjualan
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $validator =  $request->validate([
            'sales' => 'required|max:255',
            'nama' => 'required|numeric',
            'batch' => 'required|numeric',
            'jumlah' => 'required|numeric',
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
            'tanggal.required' => 'Input tanggal tidak boleh kosong',
            'tanggal.max' => 'Input tanggal tidak boleh lebih dari 255 karakter',
        ]);

        $selectedDate = $request->tanggal;

        // Convert the selected date to a timestamp (UNIX timestamp)
        $timestamp = Carbon::parse($selectedDate)->timestamp;

        $sales_pembelian = SalesPembelian::find($request->batch);

        $sales_pembelian_harga = $sales_pembelian->harga / $sales_pembelian->jumlah;
        $sales_penjualan_harga = $sales_pembelian_harga * $request->jumlah;

        SalesPenjualan::create([
            'sales_pembelian_id' => $request->batch,
            'jumlah' => $request->jumlah,
            'harga' => $sales_penjualan_harga,
            'tanggal' => $timestamp,
        ]);

        $sales_pembelian->sisa = $sales_pembelian->sisa - $request->jumlah;
        $sales_pembelian->save();

        return redirect()->route('salespenjualan.index')->with('success', 'menambahkan penjualan barang');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {

        DB::beginTransaction();

        try {
            $sales_penjualan = SalesPenjualan::find($id);
            if (!$sales_penjualan) {
                // Handle case where the resource is not found
                abort(404, 'Resource not found');
            }
    
            $sales_pembelian = SalesPembelian::find($sales_penjualan->sales_pembelian_id);
            $sales_pembelian->sisa = $sales_pembelian->sisa + $sales_penjualan->jumlah;
            $sales_pembelian->save();
    
            $sales_penjualan->delete();

            // If everything went well, commit the transaction
            DB::commit();
        } catch (\Exception $e) {
            // If an exception occurs, rollback the transaction
            DB::rollBack();

            // Handle the exception or log it as needed
            return response()->json(['error' => 'Transaction failed.'], 500);
        }

        return redirect()->route('salespenjualan.index')->with('success', 'menghapus penjualan barang');
    }
}
