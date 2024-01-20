<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PenjualanProdukBarang extends Model
{
    use HasFactory;
    protected $table = "penjualan_produk_transaksi_pembelian";
    public $timestamps = false;
    protected $primaryKey = 'id';
    protected $fillable = [
        'transaksi_pembelian_id','penjualan_produk_id','jumlah'
    ];
    public function pembelian(): BelongsTo
    {
        return $this->belongsTo(Pembelian::class, 'transaksi_pembelian_id');
    }
    public function penjualan_produk(): BelongsTo
    {
        return $this->belongsTo(PenjualanProduk::class, 'penjualan_produk_id');
    }
}
