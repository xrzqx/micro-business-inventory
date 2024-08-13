<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class InvoiceItem extends Model
{
    use HasFactory;
    protected $table = "invoice_item";
    public $timestamps = false;
    protected $primaryKey = 'id';
    protected $fillable = [
        'transaksi_pembelian_id', 'invoice_id','jumlah', 'harga', 'total_harga'
    ];
    public function invoice(): BelongsTo
    {
        return $this->belongsTo(Invoice::class, 'invoice_id');
    }
    public function pembelian(): BelongsTo
    {
        return $this->belongsTo(Pembelian::class, 'transaksi_pembelian_id');
    }
}
