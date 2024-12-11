<?php

namespace App\Http\Controllers;

use App\Models\Pegawai;
use App\Http\Controllers\Rule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class PegawaiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $pegawais = Pegawai::paginate(10);
        return view('pegawais.index', compact('pegawais'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('pegawais.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, Pegawai $pegawai)
    {
        $request->validate([
            'id_pegawai' => [
                'required',
                'string',
                Rule::unique('pegawais')->ignore($pegawai->id_pegawai, 'id_pegawai'),
            ],
            'jabatan' => 'required|string',
            'nama_pegawai' => 'required|string',
            'tanggal_lahir' => 'required|date',
            'no_hp' => 'nullable|string',
        ], [
            'id_pegawai.required' => 'ID Pegawai harus diisi.',
            'id_pegawai.unique' => 'ID Pegawai sudah terdaftar.',
            'jabatan.required' => 'Jabatan harus diisi.',
            'nama_pegawai.required' => 'Nama Pegawai harus diisi.',
            'tanggal_lahir.required' => 'Tanggal lahir harus diisi.',
        ]);

        try {
            Pegawai::create($request->all());
            return redirect()->route('pegawais.index')->with('success', 'Data pegawai berhasil disimpan!');
        } catch (\Exception $e) {
            Log::error("Error saving data: {$e->getMessage()}");
            return redirect()->back()->withErrors(['error' => 'Terjadi kesalahan saat menyimpan data.']);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Pegawai $pegawai)
    {
        return view('pegawais.show', compact('pegawai'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Pegawai $pegawai)
    {
        return view('pegawais.edit', compact('pegawai'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Pegawai $pegawai)
    {
        $request->validate([
            'id_pegawai' => [
                'required',
                'string',
                Rule::unique('pegawais')->ignore($pegawai->id_pegawai, 'id_pegawai'),
            ],          
            'jabatan' => 'required|string',
            'nama_pegawai' => 'required|string',
            'tanggal_lahir' => 'required|date',
            'no_hp' => 'nullable|string',
        ]);


        try {
            $pegawai->update($request->all());
            return redirect()->route('pegawais.index')->with('success', 'Data pegawai berhasil diperbarui!');
        } catch (\Exception $e) {
            Log::error("Error updating data: {$e->getMessage()}");
            return redirect()->back()->withErrors(['error' => 'Terjadi kesalahan saat memperbarui data.']);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Pegawai $pegawai)
    {
        try {
            $pegawai->delete();
            return redirect()->route('pegawais.index')->with('success', 'Data pegawai berhasil dihapus.');
        } catch (\Exception $e) {
            Log::error("Error deleting data: {$e->getMessage()}");
            return redirect()->route('pegawais.index')->withErrors(['error' => 'Terjadi kesalahan saat menghapus data.']);
        }
    }
}