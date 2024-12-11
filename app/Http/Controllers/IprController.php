<?php

namespace App\Http\Controllers;

use App\Models\Ipr;
use App\Models\TitikReklame;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log; // Ensure this is included
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use PDF;

class IprController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Retrieve all insurance records with pagination
        $iprs = Ipr::paginate(10);
        $titikReklames = TitikReklame::all(); // Tambahkan data titik reklame
        return view('iprs.index', compact('iprs', 'titikReklames'));
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $titikReklames = TitikReklame::all(); // Mengambil semua data titik reklame
        return view('iprs.create', compact('titikReklames'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // 1. Validasi request
        $request->validate([
            'koordinat_titik' => 'required|string',
            'no_ipr' => 'required|string',
            'periode_awal' => 'required|date|before:periode_akhir',
            'periode_akhir' => 'required|date|after:periode_awal',
            'dokumen_ipr' => 'required|file|mimes:pdf,jpg,png|max:2048',
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
            $namaFile = 'IPR-' . $lokasi . '-' . $periodeAwal . ' sd ' . $periodeAkhir . '-' . Str::uuid() . '.pdf'; 

            // 4. Simpan file
            $dokumenIprPath = $request->file('dokumen_ipr')->storeAs('uploads/ipr', $namaFile, 'public');

            // 5. Simpan data IPR ke database
            Ipr::create([
                'koordinat_titik' => $request->koordinat_titik,
                'no_ipr' => $request->no_ipr,
                'periode_awalipr' => $request->periode_awal,
                'periode_akhiripr' => $request->periode_akhir,
                'dokumen_ipr' => $dokumenIprPath, 
            ]);

            return redirect()->route('iprs.index')->with('success', 'Data saved successfully!');

        } catch (\Exception $e) {
            Log::error("Error saving data: {$e->getMessage()}");
            return redirect()->back()->withErrors(['error' => 'An unexpected error occurred while saving the data.']);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Ipr $ipr)
    {
        $titikReklames = TitikReklame::all();
        return view('iprs.show', compact('ipr', 'titikReklames'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Ipr $ipr)
    {
        $titikReklames = TitikReklame::all();
        return view('iprs.edit', compact('ipr', 'titikReklames'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Ipr $ipr)
    {
        // 1. Validasi request
        $request->validate([
            'koordinat_titik' => 'required|string',
            'no_ipr' => 'required|string',
            'periode_awal' => 'required|date|before:periode_akhir',
            'periode_akhir' => 'required|date|after:periode_awal',
            'dokumen_ipr' => 'nullable|file|mimes:pdf,jpg,png|max:2048',
        ]);

        try {
            // 2. Update atribut Ipr
            $ipr->koordinat_titik = $request->koordinat_titik;
            $ipr->no_ipr = $request->no_ipr;
            $ipr->periode_awalipr = $request->periode_awal;
            $ipr->periode_akhiripr = $request->periode_akhir;

            // 3.  Cek jika ada file baru yang diupload
            if ($request->hasFile('dokumen_ipr')) {
                // 4. Ambil data lokasi dan tahun periode
                $lokasi = TitikReklame::where('koordinat_titik', $request->koordinat_titik)->value('nama_titik'); 
                $periodeAwal = date('Y', strtotime($request->periode_awal)); 
                $periodeAkhir = date('Y', strtotime($request->periode_akhir)); 

                // 5. Generate nama file unik 
                $namaFile = 'IPR-' . $lokasi . '-' . $periodeAwal . ' sd ' . $periodeAkhir . '-' . Str::uuid() . '.pdf'; 

                // 6. Simpan file baru
                $dokumenIprPath = $request->file('dokumen_ipr')->storeAs('uploads/ipr', $namaFile, 'public');

                // 7. Hapus file lama jika ada
                if ($ipr->dokumen_ipr) {
                    Storage::disk('public')->delete($ipr->dokumen_ipr);
                }

                // 8. Update path file di model
                $ipr->dokumen_ipr = $dokumenIprPath;
            }

            // 9. Simpan perubahan data Ipr
            $ipr->save();

            return redirect()->route('iprs.index')->with('success', 'Data updated successfully!');

        } catch (\Exception $e) {
            Log::error("Error updating data: {$e->getMessage()}");
            return redirect()->back()->withErrors(['error' => 'An unexpected error occurred while updating the data.']);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Ipr $ipr)
    {
        try {
            // Check if dokumen_ipr exists and delete it
            if ($ipr->dokumen_ipr) {
                Storage::disk('public')->delete($ipr->dokumen_ipr);
            }

            // Delete the record
            $ipr->delete();

            return redirect()->route('iprs.index')->with('success', 'Data deleted successfully!');
        } catch (\Exception $e) {
            Log::error("Error deleting data: {$e->getMessage()}");
            return redirect()->back()->withErrors(['error' => 'An unexpected error occurred while deleting the data.']);
        }
    }

    public function generateReport(Request $request)
    {
        $periode_akhir = $request->input('periode_akhir');
        $iprs = Ipr::with('titikReklame')
                    ->orderBy('periode_akhiripr', 'asc');
                    if ($periode_akhir) {
                        $iprs->where('periode_akhiripr', '<=', $periode_akhir);
                    }
                    $iprs = $iprs->get();

        $titikReklames = TitikReklame::all();

        $pdf = PDF::loadView('iprs.report', compact('iprs', 'titikReklames')); 
        return $pdf->download('ipr_report.pdf'); 
    }
}
