<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Limbah extends Model
{
    use HasFactory;
    protected $table = "limbah";
    public $timestamps = false;
    protected $primaryKey = 'id';
    protected $fillable = [
        'transaksi_pembelian_id','jumlah','tanggal'
    ];
    public function pembelian(): BelongsTo
    {
        return $this->belongsTo(Pembelian::class, 'transaksi_pembelian_id');
    }
}
