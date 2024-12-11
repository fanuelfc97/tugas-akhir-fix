<?php

namespace App\Http\Controllers;

use App\Models\TitikReklame;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use PDF;

class TitikReklameController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $titikReklames = TitikReklame::paginate(10);
        return view('titikreklames.index', compact('titikReklames'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('titikreklames.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'koordinat_titik' => 'required|string',
            'nama_titik' => 'required|string',
            'ilustrasi_titik' => 'required|file|mimes:pdf,jpg,png|max:2048',
            'status_titik' => 'required|string',
            'jenis_penerangan' => 'required|string',
            'jumlah_lampu' => 'nullable|integer',
            'panjang' => 'required|numeric',
            'lebar' => 'required|numeric',
            'muka' => 'required|string',
        ], [
            'koordinat_titik.required' => 'Koordinat titik harus diisi.',
            'nama_titik.required' => 'Nama titik harus diisi.',
            'status_titik.required' => 'Status titik harus diisi.',
        ]);

        try {
            // Generate nama file unik dengan UUID
            $namaFile = 'TitikReklame-' . $request->nama_titik . '-' . Str::uuid() . '.' . $request->file('ilustrasi_titik')->getClientOriginalExtension();

            // Simpan file dengan nama yang sudah dikustomisasi
            $ilustrasiPath = $request->file('ilustrasi_titik')->storeAs('uploads/ilustrasi', $namaFile, 'public');

            TitikReklame::create([
                'koordinat_titik' => $request->koordinat_titik,
                'nama_titik' => $request->nama_titik,
                'ilustrasi_titik' => $ilustrasiPath,
                'status_titik' => $request->status_titik,
                'jenis_penerangan' => $request->jenis_penerangan,
                'jumlah_lampu' => $request->jumlah_lampu,
                'panjang' => $request->panjang,
                'lebar' => $request->lebar,
                'muka' => $request->muka,
            ]);

            return redirect()->route('titikreklames.index')->with('success', 'Data berhasil disimpan!');
        } catch (\Exception $e) {
            Log::error("Error saving data: {$e->getMessage()}");
            return redirect()->back()->withErrors(['error' => 'Terjadi kesalahan tak terduga saat menyimpan data.']);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($koordinat_titik)
    {
        $titikReklame = TitikReklame::find($koordinat_titik);
        return view('titikreklames.show', compact('titikReklame'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($koordinat_titik)
    {
        $titikReklame = TitikReklame::find($koordinat_titik); // Tambahkan ini untuk mengambil data titik reklame

        if (!$titikReklame) {
            return redirect()->route('titikreklames.index')->with('error', 'Data tidak ditemukan.');
        }

        return view('titikreklames.edit', compact('titikReklame'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, TitikReklame $titikReklame, $koordinat_titik)
    {
        $titikReklame = TitikReklame::find($koordinat_titik);

        if (!$titikReklame) {
            return redirect()->route('titikReklame.index')->with('error', 'Data tidak ditemukan atau gagal diupdate.');
        }

        $request->validate([
            'koordinat_titik' => 'required|string',
            'nama_titik' => 'required|string',
            'status_titik' => 'required|string',
            'jenis_penerangan' => 'required|string',
            'jumlah_lampu' => 'nullable|integer',
            'panjang' => 'required|numeric',
            'lebar' => 'required|numeric',
            'muka' => 'required|string',
            'ilustrasi_titik' => 'sometimes|file|mimes:pdf,jpg,png|max:2048',
        ]);

        try {
            if ($request->hasFile('ilustrasi_titik')) {
                if ($titikReklame->ilustrasi_titik && Storage::disk('public')->exists($titikReklame->ilustrasi_titik)) {
                    Storage::disk('public')->delete($titikReklame->ilustrasi_titik);
                }

                // Generate nama file unik dengan UUID
                $namaFile = 'TitikReklame-' . $request->nama_titik . '-' . Str::uuid() . '.' . $request->file('ilustrasi_titik')->getClientOriginalExtension();

                // Simpan file dengan nama yang sudah dikustomisasi
                $ilustrasiPath = $request->file('ilustrasi_titik')->storeAs('uploads/ilustrasi', $namaFile, 'public');
                $titikReklame->ilustrasi_titik = $ilustrasiPath;
            }

            $titikReklame->update($request->only([
                'koordinat_titik',
                'nama_titik',
                'status_titik',
                'jenis_penerangan',
                'jumlah_lampu',
                'panjang',
                'lebar',
                'muka'
            ]));

            return redirect()->route('titikreklames.index')->with('success', 'Data berhasil diperbarui!');
        } catch (\Exception $e) {
            Log::error("Error updating data: {$e->getMessage()}");
            return redirect()->back()->withErrors(['error' => 'Terjadi kesalahan saat memperbarui data.']);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($koordinat_titik)
    {
        $titikReklame = TitikReklame::find($koordinat_titik);

        if ($titikReklame) {
            $titikReklame->delete();
            return redirect()->route('titikreklames.index')->with('success', 'Data berhasil dihapus.');
        } else {
            return redirect()->route('titikreklames.index')->with('error', 'Data tidak ditemukan atau gagal dihapus.');
        }
    }

    public function generateReport(Request $request)
    {
        $status = $request->input('status'); // Ambil status dari request

        $titikReklames = TitikReklame::where('status_titik', $status)->get();

        $judul = ($status == 'available') ? 'List Titik Available' : 'List Titik Sold Out';

        $pdf = PDF::loadView('titikreklames.report', compact('titikReklames', 'judul'));
        return $pdf->download($judul . '.pdf');
    }
}