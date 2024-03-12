<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Customer;

class BerasCustomerController extends Controller
{
    //
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $customer = Customer::where('module', '=', 'beras')->paginate(7);
        return view("beras.customer", 
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
            'namacustomer' => 'required|max:255',
        ], [
            'namacustomer.required' => 'Input nama kategori tidak boleh kosong',
            'namacustomer.max' => 'Input nama kategori tidak boleh lebih dari 255 karakter',
        ]);
        Customer::create(
            [
                'nama' => $request->namacustomer,
                'module' => 'beras',
            ]
        );

        return redirect()->route('berascustomer.index')->with('success', 'menambahkan kategori');
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
        return view('beras.customeredit', 
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
            'nama' => 'required|max:255',
        ], [
            'nama.required' => 'Input nama kategori tidak boleh kosong',
            'nama.max' => 'Input nama kategori tidak boleh lebih dari 255 karakter',
        ]);
        $customer = Customer::find($id);
        $customer->nama = $request->nama;
        $customer->save();
        if (!$customer) {
            // Handle case where the resource is not found
            abort(404, 'Resource not found');
        }
        return redirect()->route('berascustomer.index')->with('success', 'mengubah kategori');
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
        return redirect()->route('berascustomer.index')->with('success', 'menghapus kategori');
    }

    public function search(Request $request)
    {
        //
        $searchQuery = $request->input('namacustomer');
        
        $customer = Customer::where('module', '=', 'beras')
            ->where('nama', 'like', '%' . $searchQuery . '%')
            ->paginate(7);
        return view("beras.customer", 
        [
            "customer" => $customer,
        ]);
    }
}
