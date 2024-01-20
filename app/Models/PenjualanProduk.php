<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PenjualanProduk extends Model
{
    use HasFactory;
    protected $table = "penjualan_produk";
    public $timestamps = false;
    protected $primaryKey = 'id';
    protected $fillable = [
        'produk_id','nama','jumlah','harga','tanggal'
    ];
    public function produk(): BelongsTo
    {
        return $this->belongsTo(Produk::class, 'produk_id');
    }
}
