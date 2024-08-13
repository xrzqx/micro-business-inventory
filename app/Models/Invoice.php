<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Invoice extends Model
{
    use HasFactory;
    protected $table = "invoice";
    public $timestamps = false;
    protected $primaryKey = 'id';
    protected $fillable = [
        'customer_id','no_invoice', 'harga','tanggal'
    ];
    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class, 'customer_id');
    }
    
}
