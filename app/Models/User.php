<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable // Ubah ini dari Model menjadi Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $primaryKey = 'username'; // Definisikan primary key
    public $incrementing = false;
    protected $fillable = [
        'id_pegawai',
        'username',
        'password',
        'jabatan',
    ];

    public function pegawai()
    {
        return $this->belongsTo(Pegawai::class,'id_pegawai', 'id_pegawai');
    }

}