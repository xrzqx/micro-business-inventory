<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Pembelian extends Model
{
    use HasFactory;
    protected $table = "transaksi_pembelian";
    public $timestamps = false;
    protected $primaryKey = 'id';
    protected $fillable = [
        'master_item_id', 'supplier','batch','jumlah','harga','tanggal','sisa'
    ];
    public function barang(): BelongsTo
    {
        return $this->belongsTo(Barang::class, 'master_item_id');
    }
}
