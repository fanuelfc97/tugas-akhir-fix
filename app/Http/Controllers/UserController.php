<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Pegawai;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::with('pegawai')->paginate(10);
        $pegawais = Pegawai::all();
        return view('users.index', compact('users', 'pegawais'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $pegawais = Pegawai::all();
        return view('users.create', compact('pegawais'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'pegawai_id' => [
                'required',
                'exists:pegawais,id_pegawai',
                Rule::unique('users', 'id_pegawai')->where(function ($query) {
                    return $query->where('id_pegawai', request('pegawai_id'));
                }),
                function ($attribute, $value, $fail) {
                    $pegawai = Pegawai::find($value);
                    if ($pegawai && $pegawai->jabatan == 'Staff Operasional') {
                        $fail('Pegawai dengan jabatan Staff Operasional tidak dapat dibuatkan user.');
                    }
                },
            ],
            'username' => 'required|unique:users,username',
            'password' => 'required|confirmed|min:8',
            'jabatan' => 'required|exists:pegawais,jabatan',
        ]);

        User::create([
            'id_pegawai' => $validated['pegawai_id'],
            'username' => $validated['username'],
            'password' => Hash::make($validated['password']),
            'jabatan' => $validated['jabatan'],
        ]);

        return redirect()->route('users.index')->with('success', 'User berhasil ditambahkan.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $username) // Ubah parameter menjadi string $username
    {
        $user = User::with('pegawai')->where('username', $username)->firstOrFail(); // Cari user berdasarkan username
        $pegawais = Pegawai::all();
        return view('users.edit', compact('user', 'pegawais'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $username)
    {
        try {
            $user = User::where('username', $username)->firstOrFail();

            $validated = $request->validate([
                'id_pegawai' => [
                    'required',
                    'exists:pegawais,id_pegawai',
                    Rule::unique('users', 'id_pegawai')->ignore($user->username, 'username')->where(function ($query) {
                        return $query->where('id_pegawai', request('id_pegawai'));
                    }),
                    function ($attribute, $value, $fail) {
                        $pegawai = Pegawai::find($value);
                        if ($pegawai && $pegawai->jabatan == 'Staff Operasional') {
                            $fail('Pegawai dengan jabatan Staff Operasional tidak dapat dibuatkan user.');
                        }
                    },
                ],
                'username' => [
                    'required',
                    Rule::unique('users')->ignore($user->username, 'username'),
                ],
                'password' => 'nullable|min:8|confirmed',
                'jabatan' => 'required|exists:pegawais,jabatan', 
            ]);

            // Ambil data pegawai berdasarkan id_pegawai yang dipilih
            $pegawai = Pegawai::findOrFail($validated['id_pegawai']); 

            // Update data user
            $user->id_pegawai = $validated['id_pegawai'];
            $user->username = $validated['username'];
            if ($validated['password']) {
                $user->password = Hash::make($validated['password']);
            }
            // Gunakan jabatan dari data pegawai yang valid
            $user->jabatan = $pegawai->jabatan; 
            $user->save();

            return redirect()->route('users.index')->with('success', 'User berhasil diperbarui.');

        } catch (\Exception $e) {
            \Log::error($e);
            return redirect()->back()->with('error', 'Terjadi kesalahan saat memperbarui user.');
        }
    }
    

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        $user->delete();
        return redirect()->route('users.index')->with('success', 'User berhasil dihapus.');
    }

    public function boot()
    {
        parent::boot();
    
        Route::model('user', User::class, function ($value) {
            return User::where('username', $value)->firstOrFail();
        });
    }
}