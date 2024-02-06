<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Bank;
use App\Models\Brilink;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;

class BrilinkTransaksiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $bank = Bank::all();
        $brilink = Brilink::with('bank')
        ->orderBy('tanggal', 'desc')
        ->paginate(7);
        return view("brilink.transaksi", 
        [
            "kategori" => $bank,
            "brilink" => $brilink,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator =  $request->validate([
            'customer' => 'required|max:100',
            'jumlah' => 'required|numeric',
            'bank' => 'required|numeric',
            'admin' => 'required|numeric',
            'tanggal' => 'required|max:255',
        ], [
            'customer.required' => 'Input customer tidak boleh kosong',
            'customer.max' => 'Input customer tidak boleh lebih dari 100 karakter',
            'jumlah.required' => 'Input jumlah tidak boleh kosong',
            'jumlah.numeric' => 'Input jumlah harus nomor',
            'bank.required' => 'Input bank tidak boleh kosong',
            'bank.numeric' => 'Input bank harus nomor',
            'admin.required' => 'Input admin tidak boleh kosong',
            'admin.numeric' => 'Input admin harus nomor',
            'tanggal.required' => 'Input tanggal tidak boleh kosong',
            'tanggal.max' => 'Input tanggal tidak boleh lebih dari 255 karakter',
        ]);

        $selectedDate = $request->tanggal;

        // Convert the selected date to a timestamp (UNIX timestamp)
        $timestamp = Carbon::parse($selectedDate)->timestamp;

        Brilink::create([
            'bank_id' => $request->bank,
            'nama' => $request->customer,
            'jumlah' => $request->jumlah,
            'admin' => $request->admin,
            'tanggal' => $timestamp,
        ]);

        return redirect()->route('brilink.index')->with('success', 'menambahkan transaksi');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $bank = Bank::all();
        $brilink = Brilink::with('bank')->where('id',$id)->get();
               
        if (!$brilink) {
            // Handle case where the resource is not found
            abort(404, 'Resource not found');
        }
        return view('brilink.transaksiedit', 
        [
            "kategori" => $bank,
            "brilink" => $brilink,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
        $validator =  $request->validate([
            'customer' => 'required|max:100',
            'jumlah' => 'required|numeric',
            'bank' => 'required|numeric',
            'admin' => 'required|numeric',
            'tanggal' => 'required|max:255',
        ], [
            'customer.required' => 'Input customer tidak boleh kosong',
            'customer.max' => 'Input customer tidak boleh lebih dari 100 karakter',
            'jumlah.required' => 'Input jumlah tidak boleh kosong',
            'jumlah.numeric' => 'Input jumlah harus nomor',
            'bank.required' => 'Input bank tidak boleh kosong',
            'bank.numeric' => 'Input bank harus nomor',
            'admin.required' => 'Input admin tidak boleh kosong',
            'admin.numeric' => 'Input admin harus nomor',
            'tanggal.required' => 'Input tanggal tidak boleh kosong',
            'tanggal.max' => 'Input tanggal tidak boleh lebih dari 255 karakter',
        ]);

        $selectedDate = $request->tanggal;

        // Convert the selected date to a timestamp (UNIX timestamp)
        $timestamp = Carbon::parse($selectedDate)->timestamp;

        $brilink = Brilink::find($id);
        if (!$brilink) {
            // Handle case where the resource is not found
            abort(404, 'Resource not found');
        }

        try {
            DB::beginTransaction();
        
            // Perform your database operations using the model
            $brilink->update([
                'bank_id' => $request->bank,
                'nama' => $request->customer,
                'jumlah' => $request->jumlah,
                'admin' => $request->admin,
                'tanggal' => $timestamp,
            ]);
        
            // You can perform additional model operations within the same transaction
        
            DB::commit();
        } catch (\Exception $e) {
            // An error occurred, rollback the transaction
            DB::rollback();
        
            // Handle the exception or log the error
            throw $e;
        }

        return redirect()->route('brilink.index')->with('success', 'menambahkan transaksi');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
        $brilink = Brilink::find($id);
        if (!$brilink) {
            // Handle case where the resource is not found
            abort(404, 'Resource not found');
        }
        $brilink->delete();
        return redirect()->route('brilink.index')->with('success', 'menghapus transaksi');
    }

    public function search(Request $request)
    {
        $searchQuery = $request->input('bank');
        
        $bank = Bank::all();
        $brilink = Brilink::with('bank')
        ->whereHas('bank', function (Builder $query) use ($searchQuery) {
            $query->where('nama', 'like', '%' . $searchQuery . '%');
        })
        ->paginate(7);
        return view("brilink.transaksi", 
        [
            "kategori" => $bank,
            "brilink" => $brilink,
        ]);
    }
}
