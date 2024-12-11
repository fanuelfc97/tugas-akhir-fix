<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\Models\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{
    use RegistersUsers;

    protected $redirectTo = RouteServiceProvider::HOME;

    public function __construct()
    {
        $this->middleware('guest');
    }

    protected function validator(array $data)
    {
        return Validator::make($data, [
            'username' => ['required', 'string', 'max:255', 'unique:users'],
            'id_pegawai' => ['required', 'string', 'exists:pegawais,id_pegawai'], // Validasi id_pegawai
            'jabatan' => ['required', 'string', 'exists:pegawais,jabatan'], // Validasi jabatan
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
    }

    protected function create(array $data)
    {
        return User::create([
            'username' => $data['username'],
            'id_pegawai' => $data['id_pegawai'],
            'jabatan' => $data['jabatan'],
            'password' => Hash::make($data['password']),
        ]);
    }
}