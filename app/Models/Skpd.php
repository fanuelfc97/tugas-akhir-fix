<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Skpd extends Model
{
    use HasFactory;
    protected $primaryKey = 'no_skpd';
    public $incrementing = false;

    protected $fillable = [
        'koordinat_titik',
        'no_skpd',
        'periode_awalskpd',
        'periode_akhirskpd',
        'dokumen_skpd',
    ];
    public function titikReklame()
    {
        return $this->belongsTo(TitikReklame::class, 'koordinat_titik', 'koordinat_titik');
    }
}
