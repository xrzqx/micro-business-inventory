<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Penjualan;
use App\Models\Item;
use App\Models\Pembelian;
use App\Models\Barang;
use Illuminate\Database\Eloquent\Builder;
use Carbon\Carbon;

class StudioPenjualanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

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

        // return $barang;
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

        return view('studio.penjualan',
        [
            "barang" => $barang,
            "pembelian" => $pembelian,
            "penjualan" => $penjualan,
            // "item" => $item,
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
    }
}
