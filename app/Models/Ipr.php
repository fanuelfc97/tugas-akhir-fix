<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ipr extends Model
{
    use HasFactory;

    protected $primaryKey = 'no_ipr';
    public $incrementing = false;

    protected $fillable = [
        'koordinat_titik',
        'no_ipr',
        'periode_awalipr',
        'periode_akhiripr',
        'dokumen_ipr',
    ];
    public function titikReklame()
    {
        return $this->belongsTo(TitikReklame::class, 'koordinat_titik', 'koordinat_titik');
    }
}