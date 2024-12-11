<?php

namespace App\Http\Controllers;

use App\Models\SewaLahan;
use App\Models\TitikReklame;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log; // Ensure this is included
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use PDF;

class SewaLahanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Retrieve all insurance records with pagination
        $sewalahans = SewaLahan::paginate(10);
        $titikReklames = TitikReklame::all(); // Tambahkan data titik reklame
        return view('sewalahans.index', compact('sewalahans', 'titikReklames'));
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $titikReklames = TitikReklame::all(); // Mengambil semua data titik reklame
        return view('sewalahans.create', compact('titikReklames'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // 1. Validasi request
        $request->validate([
            'koordinat_titik' => 'required|string',
            'no_kontrak' => 'required|string',
            'periode_awal' => 'required|date|before:periode_akhir',
            'periode_akhir' => 'required|date|after:periode_awal',
            'dokumen_sl' => 'required|file|mimes:pdf,jpg,png|max:2048',
        ], [
            'koordinat_titik.required' => 'Koordinat titik harus diisi.',
            // ... pesan validasi lainnya ...
        ]);

        try {
            // 2. Ambil data lokasi dan tahun periode
            $lokasi = TitikReklame::where('koordinat_titik', $request->koordinat_titik)->value('nama_titik'); 
            $periodeAwal = date('Y', strtotime($request->periode_awal)); 
            $periodeAkhir = date('Y', strtotime($request->periode_akhir)); 

            // 3. Generate nama file unik 
            $namaFile = 'SewaLahan-' . $lokasi . '-' . $periodeAwal . ' sd ' . $periodeAkhir . '-' . Str::uuid() . '.pdf'; 

            // 4. Simpan file
            $dokumenSlPath = $request->file('dokumen_sl')->storeAs('uploads/sl', $namaFile, 'public');

            // 5. Simpan data Sewa Lahan ke database
            SewaLahan::create([
                'koordinat_titik' => $request->koordinat_titik,
                'no_kontrak' => $request->no_kontrak,
                'periode_awalsl' => $request->periode_awal,
                'periode_akhirsl' => $request->periode_akhir,
                'dokumen_sl' => $dokumenSlPath, 
            ]);

            return redirect()->route('sewalahans.index')->with('success', 'Data saved successfully!');

        } catch (\Exception $e) {
            Log::error("Error saving data: {$e->getMessage()}");
            return redirect()->back()->withErrors(['error' => 'An unexpected error occurred while saving the data.']);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(SewaLahan $sewalahan)
    {
        $titikReklames = TitikReklame::all();
        return view('sewalahans.show', compact('sewalahan', 'titikReklames'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(SewaLahan $sewalahan)
    {
        $titikReklames = TitikReklame::all();
        return view('sewalahans.edit', compact('sewalahan', 'titikReklames'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, SewaLahan $sewalahan)
    {
        // 1. Validasi request
        $request->validate([
            'koordinat_titik' => 'required|string',
            'no_kontrak' => 'required|string',
            'periode_awal' => 'required|date|before:periode_akhir',
            'periode_akhir' => 'required|date|after:periode_awal',
            'dokumen_sl' => 'nullable|file|mimes:pdf,jpg,png|max:2048',
        ]);

        try {
            // 2. Update atribut Sewa Lahan
            $sewalahan->koordinat_titik = $request->koordinat_titik;
            $sewalahan->no_kontrak = $request->no_kontrak;
            $sewalahan->periode_awalsl = $request->periode_awal;
            $sewalahan->periode_akhirsl = $request->periode_akhir;

            // 3.  Cek jika ada file baru yang diupload
            if ($request->hasFile('dokumen_sl')) {
                // 4. Ambil data lokasi dan tahun periode
                $lokasi = TitikReklame::where('koordinat_titik', $request->koordinat_titik)->value('nama_titik'); 
                $periodeAwal = date('Y', strtotime($request->periode_awal)); 
                $periodeAkhir = date('Y', strtotime($request->periode_akhir)); 

                // 5. Generate nama file unik 
                $namaFile = 'SewaLahan-' . $lokasi . '-' . $periodeAwal . ' sd ' . $periodeAkhir . '-' . Str::uuid() . '.pdf'; 

                // 6. Simpan file baru
                $dokumenSlPath = $request->file('dokumen_sl')->storeAs('uploads/sl', $namaFile, 'public');

                // 7. Hapus file lama jika ada
                if ($sewalahan->dokumen_sl) {
                    Storage::disk('public')->delete($sewalahan->dokumen_sl);
                }

                // 8. Update path file di model
                $sewalahan->dokumen_sl = $dokumenSlPath;
            }

            // 9. Simpan perubahan data Sewa Lahan
            $sewalahan->save();

            return redirect()->route('sewalahans.index')->with('success', 'Data updated successfully!');

        } catch (\Exception $e) {
            Log::error("Error updating data: {$e->getMessage()}");
            return redirect()->back()->withErrors(['error' => 'An unexpected error occurred while updating the data.']);
        }
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(SewaLahan $sewalahan)
    {
        try {
            // Check if dokumen_sl exists and delete it
            if ($sewalahan->dokumen_sl) {
                Storage::disk('public')->delete($sewalahan->dokumen_sl);
            }

            // Delete the record
            $sewalahan->delete();

            return redirect()->route('sewalahans.index')->with('success', 'Data deleted successfully!');
        } catch (\Exception $e) {
            Log::error("Error deleting data: {$e->getMessage()}");
            return redirect()->back()->withErrors(['error' => 'An unexpected error occurred while deleting the data.']);
        }
    }
    public function generateReport(Request $request)
    {
        $periode_akhir = $request->input('periode_akhir');
        $sewalahans = SewaLahan::with('titikReklame')
        ->orderBy('periode_akhirsl', 'asc');
        if ($periode_akhir) {
            $sewalahans->where('periode_akhirskpd', '<=', $periode_akhir);
        }
        $sewalahans = $sewalahans->get();
        $titikReklames = TitikReklame::all();

        $pdf = PDF::loadView('sewalahans.report', compact('sewalahans', 'titikReklames')); 
        return $pdf->download('sewa_lahan_report.pdf'); 
    }
}