<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Penjualan extends Model
{
    use HasFactory;
    protected $table = "transaksi_penjualan";
    public $timestamps = false;
    protected $primaryKey = 'id';
    protected $fillable = [
        'transaksi_pembelian_id','customer_id','nama','jumlah','harga','cod','tanggal'
    ];
    public function pembelian(): BelongsTo
    {
        return $this->belongsTo(Pembelian::class, 'transaksi_pembelian_id');
    }
    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class, 'customer_id');
    }
}
