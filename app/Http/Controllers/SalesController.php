<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Sales;

class SalesController extends Controller
{
    public function index(){
        $sales = Sales::paginate(7);
        return view("sales.index", 
        [
            "sales" => $sales,
        ]);
    }
    public function store(Request $request)
    {
        $validator =  $request->validate([
            'sales' => 'required|max:255',
        ], [
            'sales.required' => 'Input nama kategori tidak boleh kosong',
            'sales.max' => 'Input nama kategori tidak boleh lebih dari 255 karakter',
        ]);
        Sales::create(
            [
                'nama' => $request->sales,
            ]
        );

        return redirect()->route('sales.index')->with('success', 'menambahkan sales');
    }

    public function edit($id)
    {
        $sales = Sales::find($id);
        if (!$sales) {
            // Handle case where the resource is not found
            abort(404, 'Resource not found');
        }
        return view('sales.edit', 
        [
            "sales" => $sales,
        ]);
    }

    public function destroy($id)
    {
        $sales = Sales::find($id);
        if (!$sales) {
            // Handle case where the resource is not found
            abort(404, 'Resource not found');
        }
        $sales->delete();
        return redirect()->route('sales.index')->with('success', 'menghapus sales');
    }

    public function update(Request $request, $id)
    {
        $validator =  $request->validate([
            'nama' => 'required|max:255',
        ], [
            'nama.required' => 'Input nama kategori tidak boleh kosong',
            'nama.max' => 'Input nama kategori tidak boleh lebih dari 255 karakter',
        ]);
        $sales = Sales::find($id);
        if (!$sales) {
            // Handle case where the resource is not found
            abort(404, 'Resource not found');
        }
        $sales->nama = $request->nama;
        $sales->save();
        return redirect()->route('sales.index')->with('success', 'mengubah sales');
    }

    public function search(Request $request)
    {
        $searchQuery = $request->input('namasales');
        
        $sales = Sales::where('nama', 'like', '%' . $searchQuery . '%')
        ->paginate(7);
        return view("sales.index", 
        [
            "sales" => $sales,
        ]);
    }
}
