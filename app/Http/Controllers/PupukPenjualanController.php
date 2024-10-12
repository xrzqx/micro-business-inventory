<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Penjualan;
use App\Models\Invoice;
use App\Models\InvoiceItem;
use App\Models\Item;
use App\Models\Pembelian;
use App\Models\Barang;
use App\Models\Customer;
use App\Exports\InvoiceExportExcel;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Builder;
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;
use Maatwebsite\Excel\Facades\Excel;

class PupukPenjualanController extends Controller
{
    //
    public function index(){

        $barang = Pembelian::select('transaksi_pembelian.master_item_id')
            ->join('master_item', 'master_item.id', '=', 'transaksi_pembelian.master_item_id')
            ->join('kategori', 'kategori.id', '=', 'master_item.kategori_id')
            ->join('item', 'item.id', '=', 'master_item.item_id')
            ->where('kategori.toko', '=', 'pupuk')
            ->where('sisa', '>', 0)
            ->groupBy('transaksi_pembelian.master_item_id')
            ->with(['barang' => function ($query) {
                $query->with('item', 'kategori');
            }])
            ->get();

        $pembelian = Pembelian::with(['barang' => function ($query) {
            $query->with('item', 'kategori')
                ->whereHas('kategori', function (Builder $query) {
                    $query->where('toko', '=', 'pupuk');
                });
        }])
        ->where('sisa', '>', 0)
        ->get();

        $penjualan = Invoice::select('invoice.*')
            ->orderBy('invoice.tanggal', 'desc')
            ->with('customer')
            ->paginate(7);


        $customer = Customer::select(['customer.id','customer.nama', 'customer.nik', 'customer.lokasi'])->where("module","pupuk")->get();

        return view('pupuk.penjualan',
        [
            "barang" => $barang,
            "pembelian" => $pembelian,
            "penjualan" => $penjualan,
            "customer" => $customer,
        ]);
    }

    public function store(Request $request)
    {
        $validator =  $request->validate([
            'invoice' => 'required|numeric',
            'tanggal' => 'required|max:255',
            'customer' => 'required|numeric',
            'namaDynamic.*' => 'required|numeric',
            'batchDynamic.*' => 'required|numeric',
            'jumlahDynamic.*' => 'required|numeric',
            'hargaDynamic.*' => 'required|numeric',
        ], [
            'invoice.required' => 'Input no invoice barang tidak boleh kosong',
            'invoice.numeric' => 'Input no invoice barang harus benar',
            'tanggal.required' => 'Input tanggal tidak boleh kosong',
            'tanggal.max' => 'Input tanggal tidak boleh lebih dari 255 karakter',
            'customer.required' => 'Input customer tidak boleh kosong',
            'customer.numeric' => 'Input nama customer harus benar',
            'namahDynamic.*.required' => 'Input nama barang tidak boleh kosong',
            'namahDynamic.*.numeric' => 'Input nama barang harus benar',
            'batchDynamic.*.required' => 'Input batch barang tidak boleh kosong',
            'batchDynamic.*.numeric' => 'Input nama barang harus benar',
            'jumlahDynamic.*.required' => 'Input jumlah tidak boleh kosong',
            'jumlahDynamic.*.numeric' => 'Input jumlah harus nomor',
            'hargaDynamic.*.required' => 'Input harga tidak boleh kosong',
            'hargaDynamic.*.numeric' => 'Input harga harus nomor',
        ]);

        $namaDynamic = $request->input('namaDynamic', []);
        $batchDynamic = $request->input('batchDynamic', []);
        $jumlahDynamic = $request->input('jumlahDynamic', []);
        $hargaDynamic = $request->input('hargaDynamic', []);

        $selectedDate = $request->tanggal;

        // Convert the selected date to a timestamp (UNIX timestamp)
        $timestamp = Carbon::parse($selectedDate)->timestamp;

        // return $selectedDate;

        // Parse the date string into a Carbon instance
        $date = Carbon::createFromFormat('d-m-Y', $selectedDate);

        // Get the month
        $month = $date->format('m');

        $year = $date->format('Y');

        $no_invoice = $request->invoice . '/SGH' . '/' . $month . '/' . $year;

        $total_harga = 0;

        $minLength = min(count($jumlahDynamic), count($hargaDynamic));

        for ($i = 0; $i < $minLength; $i++) {
            $jumlahValue = $jumlahDynamic[$i];
            $hargaValue = $hargaDynamic[$i];

            $total_harga += $jumlahValue * $hargaValue;
        }

        $penjualan_produk = Invoice::create([
            'customer_id' => $request->customer,
            'no_invoice' => $no_invoice,
            'harga' => $total_harga,
            'tanggal' => $timestamp,
        ]);

        // Make sure both arrays have the same length
        $minLength = min(count($batchDynamic), count($jumlahDynamic), count($namaDynamic), count($hargaDynamic));

        for ($i = 0; $i < $minLength; $i++) {
            $batchValue = $batchDynamic[$i];
            $jumlahValue = $jumlahDynamic[$i];
            $barangId = $namaDynamic[$i];
            $hargaValue = $hargaDynamic[$i];

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

            InvoiceItem::create([
                'transaksi_pembelian_id' => $batchValue,
                'invoice_id' => $penjualan_produk->id,
                'jumlah' => $jumlahValue,
                'harga' => $hargaValue,
                'total_harga' => $jumlahValue * $hargaValue
            ]);
            
            $item->stock = $item->stock - $jumlahValue;
            $item->save();

            $pembelian->sisa = $pembelian->sisa - $jumlahValue;
            $pembelian->save();
        }

        return redirect()->route('pupukpenjualan.index')->with('success', 'menambahkan penjualan barang');
    }

    public function edit($id)
    {
        $penjualan_produk = Invoice::find($id);
        if (!$penjualan_produk) {
            // Handle case where the resource is not found
            abort(404, 'Resource not found');
        }

        $string = $penjualan_produk->no_invoice;
        $parts = explode('/', $string);
        $number_invoice = $parts[0];
        // return $number;

        // return $penjualan_produk;

        $penjualan = InvoiceItem::where('invoice_id', '=', $id)
            ->with('invoice')
            ->get();

        // return $penjualan;

        $barang = Pembelian::select('transaksi_pembelian.master_item_id')
            ->join('master_item', 'master_item.id', '=', 'transaksi_pembelian.master_item_id')
            ->join('kategori', 'kategori.id', '=', 'master_item.kategori_id')
            ->join('item', 'item.id', '=', 'master_item.item_id')
            ->where('kategori.toko', '=', 'pupuk')
            ->where('sisa', '>', 0)
            ->groupBy('transaksi_pembelian.master_item_id')
            ->with(['barang' => function ($query) {
                $query->with('item');
            }])
            ->get();
            
        $pupuk_list = Pembelian::select(['transaksi_pembelian.id','transaksi_pembelian.master_item_id','transaksi_pembelian.batch','transaksi_pembelian.sisa','transaksi_pembelian.jumlah'])
            ->join('master_item', 'master_item.id', '=', 'transaksi_pembelian.master_item_id')
            ->join('kategori', 'kategori.id', '=', 'master_item.kategori_id')
            ->join('item', 'item.id', '=', 'master_item.item_id')
            ->where('kategori.toko', '=', 'pupuk')
            ->get();

        // return $barang;
        
        $customer = Customer::select(['customer.id','customer.nama', 'customer.nik'])->where("module","pupuk")->get();

        return view('pupuk.penjualanedit', 
        [
            "barang" => $barang,
            "pupuk_list" => $pupuk_list,
            "penjualan" => $penjualan,
            "penjualan_produk" => $penjualan_produk,
            "number_invoice" => $number_invoice,
            "customer" => $customer,
        ]);
    }

    public function update(Request $request, $id)
    {
        $validator =  $request->validate([
            'invoice' => 'required|numeric',
            'tanggal' => 'required|max:255',
            'customer' => 'required|numeric',
            'namaDynamic.*' => 'required|numeric',
            'batchDynamic.*' => 'required|numeric',
            'jumlahDynamic.*' => 'required|numeric',
            'hargaDynamic.*' => 'required|numeric',
        ], [
            'invoice.required' => 'Input no invoice barang tidak boleh kosong',
            'invoice.numeric' => 'Input no invoice barang harus benar',
            'tanggal.required' => 'Input tanggal tidak boleh kosong',
            'tanggal.max' => 'Input tanggal tidak boleh lebih dari 255 karakter',
            'customer.required' => 'Input customer tidak boleh kosong',
            'customer.numeric' => 'Input nama customer harus benar',
            'namahDynamic.*.required' => 'Input nama barang tidak boleh kosong',
            'namahDynamic.*.numeric' => 'Input nama barang harus benar',
            'batchDynamic.*.required' => 'Input batch barang tidak boleh kosong',
            'batchDynamic.*.numeric' => 'Input nama barang harus benar',
            'jumlahDynamic.*.required' => 'Input jumlah tidak boleh kosong',
            'jumlahDynamic.*.numeric' => 'Input jumlah harus nomor',
            'hargaDynamic.*.required' => 'Input harga tidak boleh kosong',
            'hargaDynamic.*.numeric' => 'Input harga harus nomor',
        ]);

        $idDynamic = $request->input('itemDynamic', []);
        $namaDynamic = $request->input('namaDynamic', []);
        $batchDynamic = $request->input('batchDynamic', []);
        $jumlahDynamic = $request->input('jumlahDynamic', []);
        $hargaDynamic = $request->input('hargaDynamic', []);

        $selectedDate = $request->tanggal;

        // Convert the selected date to a timestamp (UNIX timestamp)
        $timestamp = Carbon::parse($selectedDate)->timestamp;

        // Parse the date string into a Carbon instance
        $date = Carbon::createFromFormat('d-m-Y', $selectedDate);

        // Get the month
        $month = $date->format('m');
        $year = $date->format('Y');

        $no_invoice = $request->invoice . '/SGH' . '/' . $month . '/' . $year;


        $penjualan_produk = Invoice::find($id);
        if (!$penjualan_produk) {
            // Handle case where the resource is not found
            abort(404, 'Resource not found');
        }
        
        $total_harga = 0;
        $minLength = min(count($jumlahDynamic), count($hargaDynamic));

        for ($i = 0; $i < $minLength; $i++) {
            $jumlahValue = $jumlahDynamic[$i];
            $hargaValue = $hargaDynamic[$i];

            $total_harga += $jumlahValue * $hargaValue;
        }
        
        DB::beginTransaction();
        try {
            $penjualan_produk->no_invoice = $no_invoice;
            $penjualan_produk->customer_id = $request->customer;
            $penjualan_produk->harga = $total_harga;
            $penjualan_produk->tanggal = $timestamp;
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
        $minLength = min(count($batchDynamic), count($jumlahDynamic), count($namaDynamic), count($hargaDynamic));

        for ($i = 0; $i < $minLength; $i++) {
            $batchValue = $batchDynamic[$i];
            $jumlahValue = $jumlahDynamic[$i];
            $barangId = $namaDynamic[$i];
            $hargaValue = $hargaDynamic[$i];
            $invoiceItemId = $idDynamic[$i];

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

            $penjualan_produk_barang = InvoiceItem::find($invoiceItemId);
            if (!$penjualan_produk_barang) {
                // Handle case where the resource is not found
                abort(404, 'Resource not found');
            }
            
            if ($penjualan_produk_barang->jumlah > $jumlahValue) {
                // return true;
                DB::beginTransaction();
                try {
                    $selisih = $penjualan_produk_barang->jumlah - $jumlahValue;
                    $item->stock = $item->stock + $selisih;
                    $item->save();
                    $pembelian->sisa = $pembelian->sisa + $selisih;
                    $pembelian->save();
                    $penjualan_produk_barang->jumlah = $penjualan_produk_barang->jumlah - $selisih;
                    $penjualan_produk_barang->harga = $hargaValue;
                    $penjualan_produk_barang->total_harga = $jumlahValue * $hargaValue;
                    $penjualan_produk_barang->save();
                    // If everything went well, commit the transaction
                    DB::commit();
                } catch (\Exception $e) {
                    // If an exception occurs, rollback the transaction
                    DB::rollBack();
                
                    // Handle the exception or log it as needed
                    return response()->json(['error' => 'Transaction failed.'], 500);
                }

            }
            if ($penjualan_produk_barang->jumlah < $jumlahValue) {
                // return true;
                // return $penjualan_produk_barang;
                DB::beginTransaction();
                try {
                    $selisih = $jumlahValue - $penjualan_produk_barang->jumlah;
                    $item->stock = $item->stock - $selisih;
                    $item->save();
                    $pembelian->sisa = $pembelian->sisa - $selisih;
                    $pembelian->save();
                    $penjualan_produk_barang->jumlah = $penjualan_produk_barang->jumlah + $selisih;
                    $penjualan_produk_barang->harga = $hargaValue;
                    $penjualan_produk_barang->total_harga = $jumlahValue * $hargaValue;
                    $penjualan_produk_barang->save();
                    // If everything went well, commit the transaction
                    DB::commit();
                } catch (\Exception $e) {
                    // If an exception occurs, rollback the transaction
                    DB::rollBack();
                
                    // Handle the exception or log it as needed
                    return response()->json(['error' => 'Transaction failed.'], 500);
                }

            }
        }
        
        return redirect()->route('pupukpenjualan.index')->with('success', 'mengubah penjualan barang');
    }

    public function destroy($id)
    {
        DB::beginTransaction();

        try {
            $penjualan = InvoiceItem::where('invoice_id','=',$id)->get();
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
    
            $penjualan_produk = Invoice::find($id);
            $penjualan_produk->delete();
        
            // If everything went well, commit the transaction
            DB::commit();
        } catch (\Exception $e) {
            // If an exception occurs, rollback the transaction
            DB::rollBack();
        
            // Handle the exception or log it as needed
            return response()->json(['error' => 'Transaction failed.'], 500);
        }

        return redirect()->route('pupukpenjualan.index')->with('success', 'menghapus penjualan barang');
    }

    public function search(Request $request)
    {
        $searchStart = $request->input('start');
        $searchEnd = $request->input('end');

        if (!$searchEnd) {
            $currentTimestamp = Carbon::now();
            $searchEnd = $currentTimestamp->format('d-m-Y');
        }
        if (!$searchStart) {
            $timestampMinTx = Invoice::select(\DB::raw('min(invoice.tanggal) as tanggal'))->first();
            $dateTx = Carbon::createFromTimestamp($timestampMinTx);
            $searchStart = $dateTx->format('d-m-Y');
        }

        // Convert the selected date to a timestamp (UNIX timestamp)
        $timestampStart = Carbon::parse($searchStart)->timestamp;
        $timestampEnd = Carbon::parse($searchEnd)->timestamp;

        $barang = Pembelian::select('transaksi_pembelian.master_item_id')
            ->join('master_item', 'master_item.id', '=', 'transaksi_pembelian.master_item_id')
            ->join('kategori', 'kategori.id', '=', 'master_item.kategori_id')
            ->join('item', 'item.id', '=', 'master_item.item_id')
            ->where('kategori.toko', '=', 'pupuk')
            ->where('sisa', '>', 0)
            ->groupBy('transaksi_pembelian.master_item_id')
            ->with(['barang' => function ($query) {
                $query->with('item', 'kategori');
            }])
            ->get();

        $pembelian = Pembelian::with(['barang' => function ($query) {
            $query->with('item', 'kategori')
                ->whereHas('kategori', function (Builder $query) {
                    $query->where('toko', '=', 'pupuk');
                });
        }])
        ->where('sisa', '>', 0)
        ->get();

        $penjualan = Invoice::select('invoice.*')
            ->orderBy('invoice.tanggal', 'desc')
            ->with('customer')
            ->where('invoice.tanggal', '>=', $timestampStart)
            ->where('invoice.tanggal', '<=', $timestampEnd)
            ->paginate(7);

        $customer = Customer::select(['customer.id','customer.nama', 'customer.nik', 'customer.lokasi'])->where("module","pupuk")->get();

        return view('pupuk.penjualan',
        [
            "barang" => $barang,
            "pembelian" => $pembelian,
            "penjualan" => $penjualan,
            "customer" => $customer,
        ]);
    }

    public function invoice($id)
    {
        // Data to pass to the view
        $invoice = Invoice::find($id);

        $customer = Customer::find($invoice->customer_id);

        $invoiceItem = InvoiceItem::where('invoice_id',$id)
        ->with(['pembelian' => function ($query) {
            $query->with(['barang' => function ($query) {
                $query->with('item');
            }]);
        }])
        ->get();

        Carbon::setLocale('id'); // Set the locale to Indonesian
        $formattedDate = Carbon::parse($invoice->tanggal)->translatedFormat('d F Y');
        
        // Render the view to a PDF
        $pdf = Pdf::loadView('pdf.invoice', [
            'invoice' => $invoice,
            'customer' => $customer,
            'invoiceItem' => $invoiceItem,
            'formattedDate' => $formattedDate,
            ])->setPaper('a4', 'landscape');

        // Return the PDF as a download
        return $pdf->download('invoice.pdf');
        
        // return view('pdf.invoice',[
        //     'invoiceData' => $invoiceData,
        // ]);
    }

    public function excel()
    {
        // Download the invoice as an Excel file
        return Excel::download(new InvoiceExportExcel, 'Rekap Penjualan.xlsx');
    }
}
