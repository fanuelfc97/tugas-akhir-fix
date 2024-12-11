<?php

namespace App\Http\Controllers;

use App\Models\Asuransi;
use App\Models\TitikReklame;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log; // Ensure this is included
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use PDF;

class AsuransiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Retrieve all insurance records with pagination
        $asuransis = Asuransi::paginate(10);
        $titikReklames = TitikReklame::all(); // Tambahkan data titik reklame
        return view('asuransis.index', compact('asuransis', 'titikReklames'));
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $titikReklames = TitikReklame::all(); // Mengambil semua data titik reklame
        return view('asuransis.create', compact('titikReklames'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // 1. Validasi request
        $request->validate([
            'koordinat_titik' => 'required|string',
            'no_polis' => 'required|string',
            'periode_awal' => 'required|date|before:periode_akhir',
            'periode_akhir' => 'required|date|after:periode_awal',
            'dokumen_polis' => 'required|file|mimes:pdf,jpg,png|max:2048',
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
            $namaFile = 'Asuransi-' . $lokasi . '-' . $periodeAwal . ' sd ' . $periodeAkhir . '-' . Str::uuid() . '.pdf'; 

            // 4. Simpan file
            $dokumenPolisPath = $request->file('dokumen_polis')->storeAs('uploads/polis', $namaFile, 'public');

            // 5. Simpan data Asuransi ke database
            Asuransi::create([
                'koordinat_titik' => $request->koordinat_titik,
                'no_polis' => $request->no_polis,
                'periode_awalas' => $request->periode_awal,
                'periode_akhiras' => $request->periode_akhir,
                'dokumen_polis' => $dokumenPolisPath, 
            ]);

            return redirect()->route('asuransis.index')->with('success', 'Data saved successfully!');

        } catch (\Exception $e) {
            Log::error("Error saving data: {$e->getMessage()}");
            return redirect()->back()->withErrors(['error' => 'An unexpected error occurred while saving the data.']);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Asuransi $asuransi)
    {
        $titikReklames = TitikReklame::all();
        return view('asuransis.show', compact('asuransi', 'titikReklames'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Asuransi $asuransi)
    {
        $titikReklames = TitikReklame::all();
        return view('asuransis.edit', compact('asuransi', 'titikReklames'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Asuransi $asuransi)
    {
        // 1. Validasi request
        $request->validate([
            'koordinat_titik' => 'required|string',
            'no_polis' => 'required|string',
            'periode_awal' => 'required|date|before:periode_akhir',
            'periode_akhir' => 'required|date|after:periode_awal',
            'dokumen_polis' => 'nullable|file|mimes:pdf,jpg,png|max:2048',
        ]);

        try {
            // 2. Update atribut Asuransi
            $asuransi->koordinat_titik = $request->koordinat_titik;
            $asuransi->no_polis = $request->no_polis;
            $asuransi->periode_awalas = $request->periode_awal;
            $asuransi->periode_akhiras = $request->periode_akhir;

            // 3.  Cek jika ada file baru yang diupload
            if ($request->hasFile('dokumen_polis')) {
                // 4. Ambil data lokasi dan tahun periode
                $lokasi = TitikReklame::where('koordinat_titik', $request->koordinat_titik)->value('nama_titik'); 
                $periodeAwal = date('Y', strtotime($request->periode_awal)); 
                $periodeAkhir = date('Y', strtotime($request->periode_akhir)); 

                // 5. Generate nama file unik 
                $namaFile = 'Asuransi-' . $lokasi . '-' . $periodeAwal . ' sd ' . $periodeAkhir . '-' . Str::uuid() . '.pdf'; 

                // 6. Simpan file baru
                $dokumenPolisPath = $request->file('dokumen_polis')->storeAs('uploads/polis', $namaFile, 'public');

                // 7. Hapus file lama jika ada
                if ($asuransi->dokumen_polis) {
                    Storage::disk('public')->delete($asuransi->dokumen_polis);
                }

                // 8. Update path file di model
                $asuransi->dokumen_polis = $dokumenPolisPath;
            }

            // 9. Simpan perubahan data Asuransi
            $asuransi->save();

            return redirect()->route('asuransis.index')->with('success', 'Data updated successfully!');

        } catch (\Exception $e) {
            Log::error("Error updating data: {$e->getMessage()}");
            return redirect()->back()->withErrors(['error' => 'An unexpected error occurred while updating the data.']);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Asuransi $asuransi)
    {
        try {
            // Check if dokumen_polis exists and delete it
            if ($asuransi->dokumen_polis) {
                Storage::disk('public')->delete($asuransi->dokumen_polis);
            }

            // Delete the record
            $asuransi->delete();

            return redirect()->route('asuransis.index')->with('success', 'Data deleted successfully!');
        } catch (\Exception $e) {
            Log::error("Error deleting data: {$e->getMessage()}");
            return redirect()->back()->withErrors(['error' => 'An unexpected error occurred while deleting the data.']);
        }
    }
    public function generateReport(Request $request)
    {
        $periode_akhir = $request->input('periode_akhir');
        $asuransis = Asuransi::with('titikReklame')
                    ->orderBy('periode_akhiras', 'asc');
                    if ($periode_akhir) {
                        $asuransis->where('periode_akhiras', '<=', $periode_akhir);
                    }
                    $asuransis = $asuransis->get();

        $titikReklames = TitikReklame::all();

        $pdf = PDF::loadView('asuransis.report', compact('asuransis', 'titikReklames')); 
        return $pdf->download('asuransi_report.pdf'); 
    }
}