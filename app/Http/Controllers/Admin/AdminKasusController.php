<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Kasus;
use App\Models\Kemahasiswaan;
use App\Models\Pelapor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

class AdminKasusController extends Controller
{
    public function index()
    {
        $kasus = Kasus::with(['kemahasiswaan', 'pelapor'])
            ->orderBy('created_at', 'desc')
            ->get();
        return view('admin.kasus.index', compact('kasus'));
    }

    public function create()
    {
        $kemahasiswaan = Kemahasiswaan::all();
        $pelapor = Pelapor::all();
        return view('admin.kasus.create', compact('kemahasiswaan', 'pelapor'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'kode_pengaduan' => 'required|string|max:6|unique:kasus',
            'id_kemahasiswaan' => 'nullable|exists:kemahasiswaan,id_kemahasiswaan',
            'id_pelapor' => 'required|exists:pelapor,id_pelapor',
            'jenis_masalah' => 'required|in:bullying,kekerasan seksual,pelecehan verbal,diskriminasi,cyberbullying,lainnya',
            'urgensi' => 'required|in:segera,dalam beberapa hari,tidak mendesak',
            'dampak' => 'required|in:sangat besar,sedang,kecil',
            'status_pengaduan' => 'required|in:perlu dikonfirmasi,dikonfirmasi,ditolak,proses satgas,selesai',
            'tanggal_konfirmasi' => 'nullable|date',
            'tanggal_pengaduan' => 'required|date',
            'deskripsi_kasus' => 'required|string',
            'bukti_kasus' => 'nullable|file|mimes:jpeg,png,jpg,pdf|max:2048',
            'asal_fakultas' => 'required|string|max:50',
            'penangan_kasus' => 'nullable|string',
            'catatan_penanganan' => 'nullable|string'
        ]);

        if ($request->hasFile('bukti_kasus')) {
            $file = $request->file('bukti_kasus');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->storeAs('public/bukti_kasus', $filename);
            $validated['bukti_kasus'] = 'bukti_kasus/' . $filename;
        }

        // Set tanggal konfirmasi jika status dikonfirmasi
        if ($validated['status_pengaduan'] === 'dikonfirmasi' && !isset($validated['tanggal_konfirmasi'])) {
            $validated['tanggal_konfirmasi'] = Carbon::now();
        }

        Kasus::create($validated);
        return redirect()->route('admin.kasus.index')
            ->with('success', 'Data kasus berhasil ditambahkan');
    }

    public function show($id)
    {
        $kasus = Kasus::with(['kemahasiswaan', 'pelapor'])->findOrFail($id);
        return view('admin.kasus.show', compact('kasus'));
    }

    public function edit($id)
    {
        $kasus = Kasus::findOrFail($id);
        $kemahasiswaan = Kemahasiswaan::all();
        $pelapor = Pelapor::all();
        return view('admin.kasus.edit', compact('kasus', 'kemahasiswaan', 'pelapor'));
    }

    public function update(Request $request, $id)
    {
        $kasus = Kasus::findOrFail($id);
        
        $validated = $request->validate([
            'kode_pengaduan' => 'required|string|max:6|unique:kasus,kode_pengaduan,'.$id.',id_kasus',
            'id_kemahasiswaan' => 'nullable|exists:kemahasiswaan,id_kemahasiswaan',
            'id_pelapor' => 'required|exists:pelapor,id_pelapor',
            'jenis_masalah' => 'required|in:bullying,kekerasan seksual,pelecehan verbal,diskriminasi,cyberbullying,lainnya',
            'urgensi' => 'required|in:segera,dalam beberapa hari,tidak mendesak',
            'dampak' => 'required|in:sangat besar,sedang,kecil',
            'status_pengaduan' => 'required|in:perlu dikonfirmasi,dikonfirmasi,ditolak,proses satgas,selesai',
            'tanggal_konfirmasi' => 'nullable|date',
            'tanggal_pengaduan' => 'required|date',
            'deskripsi_kasus' => 'required|string',
            'bukti_kasus' => 'nullable|file|mimes:jpeg,png,jpg,pdf|max:2048',
            'asal_fakultas' => 'required|string|max:50',
            'penangan_kasus' => 'nullable|string',
            'catatan_penanganan' => 'nullable|string'
        ]);

        if ($request->hasFile('bukti_kasus')) {
            if ($kasus->bukti_kasus) {
                Storage::delete('public/' . $kasus->bukti_kasus);
            }
            
            $file = $request->file('bukti_kasus');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->storeAs('public/bukti_kasus', $filename);
            $validated['bukti_kasus'] = 'bukti_kasus/' . $filename;
        }

        // Set tanggal konfirmasi jika status berubah menjadi dikonfirmasi
        if ($validated['status_pengaduan'] === 'dikonfirmasi' && 
            $kasus->status_pengaduan !== 'dikonfirmasi' && 
            !isset($validated['tanggal_konfirmasi'])) {
            $validated['tanggal_konfirmasi'] = Carbon::now();
        }

        $kasus->update($validated);
        return redirect()->route('admin.kasus.index')
            ->with('success', 'Data kasus berhasil diperbarui');
    }

    public function destroy($id)
    {
        $kasus = Kasus::findOrFail($id);
        
        if ($kasus->bukti_kasus) {
            Storage::delete('public/' . $kasus->bukti_kasus);
        }
        
        $kasus->delete();
        return redirect()->route('admin.kasus.index')
            ->with('success', 'Data kasus berhasil dihapus');
    }
} 