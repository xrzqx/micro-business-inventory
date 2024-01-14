<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Barang extends Model
{
    use HasFactory;
    protected $table = "master_item";
    public $timestamps = false;
    protected $primaryKey = 'id';
    protected $fillable = [
        'item_id','kategori_id'
    ];

    public function item(): BelongsTo
    {
        return $this->belongsTo(Item::class);
    }
    public function kategori(): BelongsTo
    {
        return $this->belongsTo(Kategori::class);
    }
}
