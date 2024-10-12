<?php

namespace App\Exports;

use App\Models\InvoiceItem;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Events\AfterSheet;

class InvoiceExportExcel implements FromCollection, WithHeadings
{

    public function headings(): array
    {
        return [
            'Invoice No',
            'Customer',
            'Lokasi',
            'NIK/NPWP',
            'Nama Produk',
            'Jumlah',
            'Harga',
            'Tanggal',
        ];
    }

    public function collection()
    {
        $data = [];

        // Fetch all invoice items with their related invoices and customers
        $invoiceItems = InvoiceItem::with(['invoice.customer','pembelian' => function ($query) {
            $query->with(['barang' => function ($query) {
                $query->with('item');
            }]);
        }])
        ->get();


        // return $invoiceItems;

        foreach ($invoiceItems as $item) {
            $data[] = [
                $item->invoice->no_invoice ?? 'N/A',
                $item->invoice->customer->nama ?? 'N/A',
                $item->invoice->customer->lokasi ?? 'N/A',
                "'". $item->invoice->customer->nik ?? 'N/A',
                $item->pembelian->barang->item->nama ?? 'Unknown',
                intval($item->jumlah),
                floatval($item->harga),
                date('Y-m-d', $item->invoice->tanggal),
            ];
        }

        return collect($data);
    }
}
