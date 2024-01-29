<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SalesPembelian extends Model
{
    use HasFactory;
    protected $table = "sales_pembelian";
    public $timestamps = false;
    protected $primaryKey = 'id';
    protected $fillable = [
        'transaksi_pembelian_id', 'sales_id', 'jumlah', 'sisa' ,'harga', 'tanggal'
    ];
    public function pembelian(): BelongsTo
    {
        return $this->belongsTo(Pembelian::class, 'transaksi_pembelian_id');
    }
    public function sales(): BelongsTo
    {
        return $this->belongsTo(Sales::class, 'sales_id');
    }
}
