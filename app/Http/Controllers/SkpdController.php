<?php

namespace App\Http\Controllers;

use App\Models\Skpd;
use App\Models\TitikReklame;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log; // Ensure this is included
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use PDF;

class SkpdController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Retrieve all insurance records with pagination
        $skpds = Skpd::paginate(10);
        $titikReklames = TitikReklame::all(); // Tambahkan data titik reklame
        return view('skpds.index', compact('skpds', 'titikReklames'));
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $titikReklames = TitikReklame::all(); // Mengambil semua data titik reklame
        return view('skpds.create', compact('titikReklames'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // 1. Validasi request
        $request->validate([
            'koordinat_titik' => 'required|string',
            'no_skpd' => 'required|string',
            'periode_awal' => 'required|date|before:periode_akhir',
            'periode_akhir' => 'required|date|after:periode_awal',
            'dokumen_skpd' => 'required|file|mimes:pdf,jpg,png|max:2048',
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
            $namaFile = 'SKPD-' . $lokasi . '-' . $periodeAwal . ' sd ' . $periodeAkhir . '-' . Str::uuid() . '.pdf'; 

            // 4. Simpan file
            $dokumenSkpdPath = $request->file('dokumen_skpd')->storeAs('uploads/skpd', $namaFile, 'public');

            // 5. Simpan data SKPD ke database
            Skpd::create([
                'koordinat_titik' => $request->koordinat_titik,
                'no_skpd' => $request->no_skpd,
                'periode_awalskpd' => $request->periode_awal,
                'periode_akhirskpd' => $request->periode_akhir,
                'dokumen_skpd' => $dokumenSkpdPath, 
            ]);

            return redirect()->route('skpds.index')->with('success', 'Data saved successfully!');

        } catch (\Exception $e) {
            Log::error("Error saving data: {$e->getMessage()}");
            return redirect()->back()->withErrors(['error' => 'An unexpected error occurred while saving the data.']);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Skpd $skpd)
    {
        $titikReklames = TitikReklame::all();
        return view('skpds.show', compact('skpd', 'titikReklames'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Skpd $skpd)
    {
        $titikReklames = TitikReklame::all();
        return view('skpds.edit', compact('skpd', 'titikReklames'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Skpd $skpd)
    {
        // 1. Validasi request
        $request->validate([
            'koordinat_titik' => 'required|string',
            'no_skpd' => 'required|string',
            'periode_awal' => 'required|date|before:periode_akhir',
            'periode_akhir' => 'required|date|after:periode_awal',
            'dokumen_skpd' => 'nullable|file|mimes:pdf,jpg,png|max:2048',
        ]);

        try {
            // 2. Update atribut SKPD
            $skpd->koordinat_titik = $request->koordinat_titik;
            $skpd->no_skpd = $request->no_skpd;
            $skpd->periode_awalskpd = $request->periode_awal;
            $skpd->periode_akhirskpd = $request->periode_akhir;

            // 3.  Cek jika ada file baru yang diupload
            if ($request->hasFile('dokumen_skpd')) {
                // 4. Ambil data lokasi dan tahun periode
                $lokasi = TitikReklame::where('koordinat_titik', $request->koordinat_titik)->value('nama_titik'); 
                $periodeAwal = date('Y', strtotime($request->periode_awal)); 
                $periodeAkhir = date('Y', strtotime($request->periode_akhir)); 

                // 5. Generate nama file unik 
                $namaFile = 'SKPD-' . $lokasi . '-' . $periodeAwal . ' sd ' . $periodeAkhir . '-' . Str::uuid() . '.pdf'; 

                // 6. Simpan file baru
                $dokumenSkpdPath = $request->file('dokumen_skpd')->storeAs('uploads/skpd', $namaFile, 'public');

                // 7. Hapus file lama jika ada
                if ($skpd->dokumen_skpd) {
                    Storage::disk('public')->delete($skpd->dokumen_skpd);
                }

                // 8. Update path file di model
                $skpd->dokumen_skpd = $dokumenSkpdPath;
            }

            // 9. Simpan perubahan data SKPD
            $skpd->save();

            return redirect()->route('skpds.index')->with('success', 'Data updated successfully!');

        } catch (\Exception $e) {
            Log::error("Error updating data: {$e->getMessage()}");
            return redirect()->back()->withErrors(['error' => 'An unexpected error occurred while updating the data.']);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Skpd $skpd)
    {
        try {
            // Check if dokumen_skpd exists and delete it
            if ($skpd->dokumen_skpd) {
                Storage::disk('public')->delete($skpd->dokumen_skpd);
            }

            // Delete the record
            $skpd->delete();

            return redirect()->route('skpds.index')->with('success', 'Data deleted successfully!');
        } catch (\Exception $e) {
            Log::error("Error deleting data: {$e->getMessage()}");
            return redirect()->back()->withErrors(['error' => 'An unexpected error occurred while deleting the data.']);
        }
    }

    public function generateReport(Request $request)
    {
        $periode_akhir = $request->input('periode_akhir');
        $skpds = Skpd::with('titikReklame')
                    ->orderBy('periode_akhirskpd', 'asc');
                    if ($periode_akhir) {
                        $skpds->where('periode_akhirskpd', '<=', $periode_akhir);
                    }
                    $skpds = $skpds->get();

        $titikReklames = TitikReklame::all();

        $pdf = PDF::loadView('skpds.report', compact('skpds', 'titikReklames')); 
        return $pdf->download('skpd_report.pdf'); 
    }
}
