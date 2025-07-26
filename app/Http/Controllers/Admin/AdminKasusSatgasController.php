<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\KasusSatgas;
use App\Models\Kasus;
use App\Models\Satgas;
use Illuminate\Http\Request;
use Carbon\Carbon;

class AdminKasusSatgasController extends Controller
{
    public function index()
    {
        $kasusSatgas = KasusSatgas::with(['kasus', 'satgas'])
            ->orderBy('tanggal_tindak_lanjut', 'desc')
            ->get();
        return view('admin.kasus_satgas.index', compact('kasusSatgas'));
    }

    public function create()
    {
        $kasus = Kasus::where('status', 'Dikonfirmasi')
            ->orWhere('status', 'Diproses')
            ->get();
        $satgas = Satgas::all();
        return view('admin.kasus_satgas.create', compact('kasus', 'satgas'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'id_kasus' => [
                'required',
                'exists:kasus,id_kasus',
                function ($attribute, $value, $fail) use ($request) {
                    // Cek apakah kombinasi id_kasus dan id_satgas sudah ada
                    $exists = KasusSatgas::where('id_kasus', $value)
                        ->where('id_satgas', $request->id_satgas)
                        ->exists();
                    if ($exists) {
                        $fail('Satgas sudah ditugaskan untuk kasus ini.');
                    }
                },
            ],
            'id_satgas' => 'required|exists:satgas,id_satgas',
            'tanggal_tindak_lanjut' => 'required|date',
            'tanggal_tindak_selesai' => 'nullable|date|after_or_equal:tanggal_tindak_lanjut',
            'status_tindak_lanjut' => 'required|in:selesai,proses'
        ]);

        // Update status kasus menjadi proses satgas
        $kasus = Kasus::find($validated['id_kasus']);
        $kasus->update(['status' => 'Diproses']);

        KasusSatgas::create($validated);
        return redirect()->route('admin.kasus-satgas.index')
            ->with('success', 'Penugasan satgas berhasil ditambahkan');
    }

    public function show($idKasus, $idSatgas)
    {
        $kasusSatgas = KasusSatgas::with(['kasus', 'satgas'])
            ->where('id_kasus', $idKasus)
            ->where('id_satgas', $idSatgas)
            ->firstOrFail();
        return view('admin.kasus_satgas.show', compact('kasusSatgas'));
    }

    public function edit($idKasus, $idSatgas)
    {
        $kasusSatgas = KasusSatgas::where('id_kasus', $idKasus)
            ->where('id_satgas', $idSatgas)
            ->firstOrFail();
        $kasus = Kasus::all();
        $satgas = Satgas::all();
        return view('admin.kasus_satgas.edit', compact('kasusSatgas', 'kasus', 'satgas'));
    }

    public function update(Request $request, $idKasus, $idSatgas)
    {
        $kasusSatgas = KasusSatgas::where('id_kasus', $idKasus)
            ->where('id_satgas', $idSatgas)
            ->firstOrFail();

        $validated = $request->validate([
            'tanggal_tindak_lanjut' => 'required|date',
            'tanggal_tindak_selesai' => 'nullable|date|after_or_equal:tanggal_tindak_lanjut',
            'status_tindak_lanjut' => 'required|in:selesai,proses'
        ]);

        // Jika status berubah menjadi selesai, set tanggal selesai
        if ($validated['status_tindak_lanjut'] === 'selesai' && !isset($validated['tanggal_tindak_selesai'])) {
            $validated['tanggal_tindak_selesai'] = Carbon::now();
        }

        $kasusSatgas->update($validated);

        // Update status kasus jika semua satgas telah menyelesaikan tugasnya
        $kasus = Kasus::find($idKasus);
        $allSatgasFinished = KasusSatgas::where('id_kasus', $idKasus)
            ->where('status_tindak_lanjut', '!=', 'selesai')
            ->doesntExist();

        if ($allSatgasFinished) {
            $kasus->update(['status' => 'Selesai']);
        }

        return redirect()->route('admin.kasus-satgas.index')
            ->with('success', 'Data penugasan satgas berhasil diperbarui');
    }

    public function destroy($idKasus, $idSatgas)
    {
        $kasusSatgas = KasusSatgas::where('id_kasus', $idKasus)
            ->where('id_satgas', $idSatgas)
            ->firstOrFail();
            
        $kasusSatgas->delete();
        return redirect()->route('admin.kasus-satgas.index')
            ->with('success', 'Data penugasan satgas berhasil dihapus');
    }
} 