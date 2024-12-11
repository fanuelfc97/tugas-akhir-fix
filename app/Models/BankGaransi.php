<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BankGaransi extends Model
{
    use HasFactory;
    protected $primaryKey = 'no_jaminan';
    public $incrementing = false;

    protected $fillable = [
        'koordinat_titik',
        'no_jaminan',
        'periode_awalbg',
        'periode_akhirbg',
        'dokumen_bg',
    ];
    public function titikReklame()
    {
        return $this->belongsTo(TitikReklame::class, 'koordinat_titik', 'koordinat_titik');
    }
}