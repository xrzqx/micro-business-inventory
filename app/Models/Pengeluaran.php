<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pengeluaran extends Model
{
    use HasFactory;
    protected $table = "pengeluaran";
    public $timestamps = false;
    protected $primaryKey = 'id';
    protected $fillable = [
        'nama', 'harga','tanggal','toko'
    ];
}
