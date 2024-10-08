<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;
    protected $table = "customer";
    public $timestamps = false;
    protected $primaryKey = 'id';
    protected $fillable = [
        'nama', 'module', 'nomor', 'nik', 'lokasi'
    ];
}
