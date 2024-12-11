<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TitikReklame extends Model
{
    use HasFactory;

    protected $primaryKey = 'koordinat_titik';
    public $incrementing = false;

    protected $fillable = [
        'koordinat_titik',
        'nama_titik',
        'ilustrasi_titik',
        'status_titik',
        'jenis_penerangan',
        'jumlah_lampu',
        'panjang',
        'lebar',
        'muka',
    ];
}