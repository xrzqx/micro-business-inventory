<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    use HasFactory;
    protected $table = "item";
    public $timestamps = false;
    protected $primaryKey = 'id';
    protected $fillable = [
        'kode','nama'
    ];
}
