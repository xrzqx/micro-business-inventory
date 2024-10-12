<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Customer;

class PupukCustomerController extends Controller
{
    //
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $customer = Customer::where('module', '=', 'pupuk')->paginate(7);
        return view("pupuk.customer", 
        [
            "customer" => $customer,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $validator =  $request->validate([
            'namacustomer' => 'required|max:100',
            'nik' => 'required|unique:customer,nik|max:20',
            'lokasi' => 'required|max:100',
        ], [
            'namacustomer.required' => 'Input nama customer tidak boleh kosong',
            'namacustomer.max' => 'Input nama customer tidak boleh lebih dari 100 karakter',
            'nik.required' => 'Input nik tidak boleh kosong',
            'nik.unique' => 'NIK/NPWP sudah terdaftar',
            'nik.max' => 'NIK/NPWP tidak boleh lebih dari 20 digit',
            'lokasi.required' => 'Input nama lokasi tidak boleh kosong',
            'lokasi.max' => 'Input nama lokasi tidak boleh lebih dari 100 karakter',
        ]);

        Customer::create(
            [
                'nama' => $request->namacustomer,
                'nik' => $request->nik,
                'lokasi' => $request->lokasi,
                'module' => 'pupuk',
            ]
        );

        return redirect()->route('pupukcustomer.index')->with('success', 'menambahkan kategori');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
        $customer = Customer::find($id);
        if (!$customer) {
            // Handle case where the resource is not found
            abort(404, 'Resource not found');
        }
        return view('pupuk.customeredit', 
        [
            "customer" => $customer,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
        $validator =  $request->validate([
            'nama' => 'required|max:100',
            'nik' => 'required|unique:customer,nik,' . $id . '|max:20',
            'lokasi' => 'required|max:20',
        ], [
            'nama.required' => 'Input nama customer tidak boleh kosong',
            'nama.max' => 'Input nama customer tidak boleh lebih dari 100 karakter',
            'nik.required' => 'Input nik tidak boleh kosong',
            'nik.unique' => 'NIK/NPWP sudah terdaftar',
            'nik.max' => 'NIK/NPWP tidak boleh lebih dari 20 digit',
            'lokasi.required' => 'Input nama lokasi tidak boleh kosong',
            'lokasi.max' => 'Input nama lokasi tidak boleh lebih dari 20 karakter',
        ]);
        $customer = Customer::find($id);
        $customer->nama = $request->nama;
        $customer->nik = $request->nik;
        $customer->lokasi = $request->lokasi;
        $customer->save();
        if (!$customer) {
            // Handle case where the resource is not found
            abort(404, 'Resource not found');
        }
        return redirect()->route('pupukcustomer.index')->with('success', 'mengubah kategori');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
        $customer = Customer::find($id);
        if (!$customer) {
            // Handle case where the resource is not found
            abort(404, 'Resource not found');
        }
        $customer->delete();
        return redirect()->route('pupukcustomer.index')->with('success', 'menghapus kategori');
    }

    public function search(Request $request)
    {
        //
        $searchQuery = $request->input('namacustomer');
        
        $customer = Customer::where('module', '=', 'pupuk')
            ->where('nama', 'like', '%' . $searchQuery . '%')
            ->paginate(7);
        return view("pupuk.customer", 
        [
            "customer" => $customer,
        ]);
    }
}
