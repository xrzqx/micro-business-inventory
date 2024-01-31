<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bank extends Model
{
    use HasFactory;
    protected $table = "bank";
    public $timestamps = false;
    protected $primaryKey = 'id';
    protected $fillable = [
        'nama'
    ];
}
