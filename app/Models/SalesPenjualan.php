<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SalesPenjualan extends Model
{
    use HasFactory;
    protected $table = "sales_penjualan";
    public $timestamps = false;
    protected $primaryKey = 'id';
    protected $fillable = [
        'sales_pembelian_id', 'jumlah', 'harga', 'tanggal'
    ];
    public function sales_pembelian(): BelongsTo
    {
        return $this->belongsTo(SalesPembelian::class, 'sales_pembelian_id');
    }
}
