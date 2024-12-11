<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Imb extends Model
{
    use HasFactory;
    protected $primaryKey = 'no_imb';
    public $incrementing = false;

    protected $fillable = [
        'no_imb',
        'koordinat_titik',
        'periode_imb',
        'dokumen_imb',
    ];
    public function titikReklame()
    {
        return $this->belongsTo(TitikReklame::class, 'koordinat_titik', 'koordinat_titik');
    }
}

