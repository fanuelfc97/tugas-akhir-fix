<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Asuransi extends Model
{
    use HasFactory;
    protected $primaryKey = 'no_polis';
    public $incrementing = false;

        protected $fillable = [
            'koordinat_titik',
            'no_polis',
            'periode_awalas',
            'periode_akhiras',
            'dokumen_polis',
        ];

        public function titikReklame()
        {
            return $this->belongsTo(TitikReklame::class, 'koordinat_titik', 'koordinat_titik');
        }
}