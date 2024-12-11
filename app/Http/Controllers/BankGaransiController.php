<?php

namespace App\Http\Controllers;

use App\Models\BankGaransi;
use App\Models\TitikReklame;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log; // Ensure this is included
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use PDF;

class BankGaransiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Retrieve all insurance records with pagination
        $bankgaransis = BankGaransi::paginate(10);
        $titikReklames = TitikReklame::all(); // Tambahkan data titik reklame
        return view('bankgaransis.index', compact('bankgaransis', 'titikReklames'));
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $titikReklames = TitikReklame::all(); // Mengambil semua data titik reklame
        return view('bankgaransis.create', compact('titikReklames'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // 1. Validasi request
        $request->validate([
            'koordinat_titik' => 'required|string',
            'no_jaminan' => 'required|string',
            'periode_awal' => 'required|date|before:periode_akhir',
            'periode_akhir' => 'required|date|after:periode_awal',
            'dokumen_bg' => 'required|file|mimes:pdf,jpg,png|max:2048',
        ], [
            'koordinat_titik.required' => 'Koordinat titik harus diisi.',
            'no_jaminan.required' => 'Isi no jaminan.',
            'periode_awal.required' => 'Isi awal periode.',
            'periode_akhir.required' => 'Isi akhir periode.',
            'dokumen_bg.required' => 'Lampirkan dokumen.',
            // ... pesan validasi lainnya ...
        ]);

        try {
            // 2. Ambil data lokasi dan tahun periode
            $lokasi = TitikReklame::where('koordinat_titik', $request->koordinat_titik)->value('nama_titik'); 
            $periodeAwal = date('Y', strtotime($request->periode_awal)); 
            $periodeAkhir = date('Y', strtotime($request->periode_akhir)); 

            // 3. Generate nama file unik 
            $namaFile = 'BankGaransi-' . $lokasi . '-' . $periodeAwal . ' sd ' . $periodeAkhir . '-' . Str::uuid() . '.pdf'; 

            // 4. Simpan file
            $dokumenBgPath = $request->file('dokumen_bg')->storeAs('uploads/bg', $namaFile, 'public');

            // 5. Simpan data Bank Garansi ke database
            BankGaransi::create([
                'koordinat_titik' => $request->koordinat_titik,
                'no_jaminan' => $request->no_jaminan,
                'periode_awalbg' => $request->periode_awal,
                'periode_akhirbg' => $request->periode_akhir,
                'dokumen_bg' => $dokumenBgPath, 
            ]);

            return redirect()->route('bankgaransis.index')->with('success', 'Data saved successfully!');

        } catch (\Exception $e) {
            Log::error("Error saving data: {$e->getMessage()}");
            return redirect()->back()->withErrors(['error' => 'An unexpected error occurred while saving the data.']);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(BankGaransi $bankgaransi)
    {
        $titikReklames = TitikReklame::all();
        return view('bankgaransis.show', compact('bankgaransi', 'titikReklames'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(BankGaransi $bankgaransi)
    {
        $titikReklames = TitikReklame::all();
        return view('bankgaransis.edit', compact('bankgaransi', 'titikReklames'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, BankGaransi $bankgaransi)
    {
        // 1. Validasi request
        $request->validate([
            'koordinat_titik' => 'required|string',
            'no_jaminan' => 'required|string',
            'periode_awal' => 'required|date|before:periode_akhir',
            'periode_akhir' => 'required|date|after:periode_awal',
            'dokumen_bg' => 'nullable|file|mimes:pdf,jpg,png|max:2048',
        ]);

        try {
            // 2. Update atribut Bank Garansi
            $bankgaransi->koordinat_titik = $request->koordinat_titik;
            $bankgaransi->no_jaminan = $request->no_jaminan;
            $bankgaransi->periode_awalbg = $request->periode_awal;
            $bankgaransi->periode_akhirbg = $request->periode_akhir;

            // 3.  Cek jika ada file baru yang diupload
            if ($request->hasFile('dokumen_bg')) {
                // 4. Ambil data lokasi dan tahun periode
                $lokasi = TitikReklame::where('koordinat_titik', $request->koordinat_titik)->value('nama_titik'); 
                $periodeAwal = date('Y', strtotime($request->periode_awal)); 
                $periodeAkhir = date('Y', strtotime($request->periode_akhir)); 

                // 5. Generate nama file unik 
                $namaFile = 'BankGaransi-' . $lokasi . '-' . $periodeAwal . ' sd ' . $periodeAkhir . '-' . Str::uuid() . '.pdf'; 

                // 6. Simpan file baru
                $dokumenBgPath = $request->file('dokumen_bg')->storeAs('uploads/bg', $namaFile, 'public');

                // 7. Hapus file lama jika ada
                if ($bankgaransi->dokumen_bg) {
                    Storage::disk('public')->delete($bankgaransi->dokumen_bg);
                }

                // 8. Update path file di model
                $bankgaransi->dokumen_bg = $dokumenBgPath;
            }

            // 9. Simpan perubahan data Bank Garansi
            $bankgaransi->save();

            return redirect()->route('bankgaransis.index')->with('success', 'Data updated successfully!');

        } catch (\Exception $e) {
            Log::error("Error updating data: {$e->getMessage()}");
            return redirect()->back()->withErrors(['error' => 'An unexpected error occurred while updating the data.']);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(BankGaransi $bankgaransi)
    {
        try {
            // Check if dokumen_bg exists and delete it
            if ($bankgaransi->dokumen_bg) {
                Storage::disk('public')->delete($bankgaransi->dokumen_bg);
            }

            // Delete the record
            $bankgaransi->delete();

            return redirect()->route('bankgaransis.index')->with('success', 'Data deleted successfully!');
        } catch (\Exception $e) {
            Log::error("Error deleting data: {$e->getMessage()}");
            return redirect()->back()->withErrors(['error' => 'An unexpected error occurred while deleting the data.']);
        }
    }
    
    public function generateReport(Request $request) 
    {
        $periode_akhir = $request->input('periode_akhir');
        $bankgaransis = BankGaransi::with('titikReklame')
                    ->orderBy('periode_akhirbg', 'asc');
                    if ($periode_akhir) {
                        $bankgaransis->where('periode_akhirbg', '<=', $periode_akhir);
                    }
                    $bankgaransis = $bankgaransis->get();

        $titikReklames = TitikReklame::all();

        $pdf = PDF::loadView('bankgaransis.report', compact('bankgaransis', 'titikReklames')); 
        return $pdf->download('bank_garansi_report.pdf'); 
    }
}
