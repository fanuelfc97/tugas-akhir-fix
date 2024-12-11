<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pegawai extends Model
{
    use HasFactory;

    protected $primaryKey = 'id_pegawai';
       public $incrementing = false;
       
       protected $fillable = [
           'id_pegawai',
           'jabatan',
           'nama_pegawai',
           'tanggal_lahir',
           'no_hp',
       ];
   }