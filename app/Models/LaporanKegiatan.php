<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LaporanKegiatan extends Model
{
    use HasFactory;

    protected $primaryKey = 'no_laporan';
    public $incrementing = false;

    protected $fillable = [
        'no_laporan',
        'koordinat_titik',
        'jenis_kegiatan',
        'tanggal_kegiatan',
        'id_pegawai',
        'laporan',
    ];

    public function resolveRouteBinding($value, $field = null)
    {
        return $this->where('no_laporan', $value)->firstOrFail();
    }
    public function titikReklame()
    {
        return $this->belongsTo(TitikReklame::class, 'koordinat_titik', 'koordinat_titik'); 
    }
    public function pegawai()
    {
        return $this->belongsTo(Pegawai::class, 'id_pegawai', 'id_pegawai'); 
    }
}