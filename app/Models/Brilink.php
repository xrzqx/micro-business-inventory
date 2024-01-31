<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Brilink extends Model
{
    use HasFactory;
    protected $table = "brilink";
    public $timestamps = false;
    protected $primaryKey = 'id';
    protected $fillable = [
        'bank_id','nama', 'jumlah', 'admin', 'tanggal'
    ];

    public function bank(): BelongsTo
    {
        return $this->belongsTo(Bank::class, 'bank_id');
    }
}
