<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Beban extends Model
{
    use HasFactory;
    protected $table = "beban";
    public $timestamps = false;
    protected $primaryKey = 'id';
    protected $fillable = [
        'kategori_id','toko_id','harga', 'tanggal'
    ];
    
    public function kategori(): BelongsTo
    {
        return $this->belongsTo(Kategori::class);
    }
    
    public function toko(): BelongsTo
    {
        return $this->belongsTo(Toko::class);
    }
}
