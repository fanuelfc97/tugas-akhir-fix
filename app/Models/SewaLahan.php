<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SewaLahan extends Model
{
    use HasFactory;
    protected $primaryKey = 'no_kontrak';
    public $incrementing = false;

    protected $fillable = [
        'koordinat_titik',
        'no_kontrak',
        'periode_awalsl',
        'periode_akhirsl',
        'dokumen_sl',
    ];
    public function titikReklame()
    {
        return $this->belongsTo(TitikReklame::class, 'koordinat_titik', 'koordinat_titik');
    }
}