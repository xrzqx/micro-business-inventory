<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pinjaman;
use App\Models\Customer;
use Carbon\Carbon;

class PinjamanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $customer = Customer::where('module','pinjaman')->get();
        $pinjaman = Pinjaman::with('customer')
            ->orderBy('tanggal', 'desc')
            ->paginate(7);
        return view("pinjaman.index", 
        [
            "pinjaman" => $pinjaman,
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
            'debit' => 'nullable|numeric',
            'kredit' => 'nullable|numeric',
            'tanggal' => 'required|max:255',
        ], [
            'customer.required' => 'Input nama kategori tidak boleh kosong',
            'customer.numeric' => 'Input nama customer harus benar',
            'debit.numeric' => 'Input jumlah harus nomor',
            'kredit.numeric' => 'Input jumlah harus nomor',
            'tanggal.required' => 'Input tanggal tidak boleh kosong',
            'tanggal.max' => 'Input tanggal tidak boleh lebih dari 255 karakter',
        ]);

        $selectedDate = $request->tanggal;

        // Convert the selected date to a timestamp (UNIX timestamp)
        $timestamp = Carbon::parse($selectedDate)->timestamp;
        $debit = 0;
        if ($request->debit) {
            $debit = $request->debit;
        }
        $kredit = 0;
        if ($request->kredit) {
            $kredit = $request->kredit;
        }

        Pinjaman::create(
            [
                'customer_id' => $request->customer,
                'debit' => $debit,
                'kredit' => $kredit,
                'tanggal' => $timestamp,
            ]
        );

        return redirect()->route('pinjaman.index')->with('success', 'menambahkan pinjaman');
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
        $customer = Customer::all();
        $pinjaman = Pinjaman::find($id);
        if (!$pinjaman) {
            // Handle case where the resource is not found
            abort(404, 'Resource not found');
        }
        return view('pinjaman.indexedit', 
        [
            "customer" => $customer,
            "pinjaman" => $pinjaman,
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
            'debit' => 'nullable|numeric',
            'kredit' => 'nullable|numeric',
            'tanggal' => 'required|max:255',
        ], [
            'customer.required' => 'Input nama kategori tidak boleh kosong',
            'customer.numeric' => 'Input nama customer harus benar',
            'debit.numeric' => 'Input jumlah harus nomor',
            'kredit.numeric' => 'Input jumlah harus nomor',
            'tanggal.required' => 'Input tanggal tidak boleh kosong',
            'tanggal.max' => 'Input tanggal tidak boleh lebih dari 255 karakter',
        ]);

        $selectedDate = $request->tanggal;

        // Convert the selected date to a timestamp (UNIX timestamp)
        $timestamp = Carbon::parse($selectedDate)->timestamp;
        $debit = 0;
        if ($request->debit) {
            $debit = $request->debit;
        }
        $kredit = 0;
        if ($request->kredit) {
            $kredit = $request->kredit;
        }

        $pinjaman = Pinjaman::find($id);
        $pinjaman->customer_id = $request->customer;
        $pinjaman->debit = $debit;
        $pinjaman->kredit = $kredit;
        $pinjaman->tanggal = $timestamp;
        $pinjaman->save();

        return redirect()->route('pinjaman.index')->with('success', 'mengedit daftar pinjaman');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $pinjaman = Pinjaman::find($id);
        if (!$pinjaman) {
            // Handle case where the resource is not found
            abort(404, 'Resource not found');
        }
        $pinjaman->delete();
        return redirect()->route('pinjaman.index')->with('success', 'menghapus pinjaman');
    }

    public function search(Request $request)
    {
        $searchQuery = $request->input('nama');

        $pinjaman = Pinjaman::select('pinjaman.*')
            ->join('customer', 'customer.id', '=', 'pinjaman.customer_id')
            ->where('customer.nama', 'like', '%' . $searchQuery . '%')
            ->with('customer')
            ->orderBy('tanggal', 'desc')
            ->paginate(7);

        $customer = Customer::all();

        return view("pinjaman.index", 
        [
            "pinjaman" => $pinjaman,
            "customer" => $customer,
        ]);
    }
}
