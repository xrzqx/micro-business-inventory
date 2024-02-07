<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Customer;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(){
        $customer = Customer::paginate(7);
        return view("pinjaman.customer", 
        [
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
        $validator =  $request->validate([
            'customer' => 'required|max:255',
        ], [
            'customer.required' => 'Input nama kategori tidak boleh kosong',
            'customer.max' => 'Input nama kategori tidak boleh lebih dari 255 karakter',
        ]);
        Customer::create(
            [
                'nama' => $request->customer,
            ]
        );
        return redirect()->route('customer.index')->with('success', 'menambahkan customer');
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
        $customer = Customer::find($id);
        if (!$customer) {
            // Handle case where the resource is not found
            abort(404, 'Resource not found');
        }
        return view('pinjaman.customeredit', 
        [
            "customer" => $customer,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $validator =  $request->validate([
            'nama' => 'required|max:255',
        ], [
            'nama.required' => 'Input nama kategori tidak boleh kosong',
            'nama.max' => 'Input nama kategori tidak boleh lebih dari 255 karakter',
        ]);
        $customer = Customer::find($id);
        if (!$customer) {
            // Handle case where the resource is not found
            abort(404, 'Resource not found');
        }
        $customer->nama = $request->nama;
        $customer->save();
        return redirect()->route('customer.index')->with('success', 'mengubah customer');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $customer = Customer::find($id);
        if (!$customer) {
            // Handle case where the resource is not found
            abort(404, 'Resource not found');
        }
        $customer->delete();
        return redirect()->route('customer.index')->with('success', 'menghapus customer');
    }

    public function search(Request $request)
    {
        $searchQuery = $request->input('customer');
        
        $customer = Customer::where('nama', 'like', '%' . $searchQuery . '%')
        ->paginate(7);
        return view("pinjaman.customer", 
        [
            "customer" => $customer,
        ]);
    }
}
