<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Pinjaman extends Model
{
    use HasFactory;
    protected $table = "pinjaman";
    public $timestamps = false;
    protected $primaryKey = 'id';
    protected $fillable = [
        'customer_id', 'debit','kredit','tanggal','keterangan'
    ];
    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class, 'customer_id');
    }
}
