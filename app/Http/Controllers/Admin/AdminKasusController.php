<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Kasus;
use App\Models\Pelapor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

class AdminKasusController extends Controller
{
    public function index()
    {
        $kasus = Kasus::with(['pelapor'])
            ->orderBy('created_at', 'desc')
            ->get();
        return view('admin.kasus.index', compact('kasus'));
    }

    public function create()
    {
        $pelapor = Pelapor::all();
        return view('admin.kasus.create', compact('pelapor'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'no_pengaduan' => 'required|string|unique:kasus',
            'pelapor_id' => 'required|exists:pelapor,id_pelapor',
            'judul_pengaduan' => 'required|string',
            'deskripsi' => 'required|string',
            'lokasi_fasilitas' => 'required|string',
            'jenis_fasilitas' => 'required|string',
            'tingkat_urgensi' => 'required|in:Rendah,Sedang,Tinggi',
            'foto_bukti' => 'nullable|file|mimes:jpeg,png,jpg|max:2048',
            'tanggal_pengaduan' => 'required|date'
        ]);

        if ($request->hasFile('foto_bukti')) {
            $file = $request->file('foto_bukti');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->storeAs('public/foto_bukti', $filename);
            $validated['foto_bukti'] = 'foto_bukti/' . $filename;
        }

        $validated['status'] = 'Menunggu';
        
        Kasus::create($validated);
        return redirect()->route('admin.kasus.index')
            ->with('success', 'Data kasus berhasil ditambahkan');
    }

    public function show($id)
    {
        $kasus = Kasus::with(['pelapor'])->findOrFail($id);
        return view('admin.kasus.show', compact('kasus'));
    }

    public function edit($id)
    {
        $kasus = Kasus::findOrFail($id);
        $pelapor = Pelapor::all();
        return view('admin.kasus.edit', compact('kasus', 'pelapor'));
    }

    public function update(Request $request, $id)
    {
        $kasus = Kasus::findOrFail($id);
        
        $validated = $request->validate([
            'no_pengaduan' => 'required|string|unique:kasus,no_pengaduan,'.$id.',id',
            'pelapor_id' => 'required|exists:pelapor,id_pelapor',
            'judul_pengaduan' => 'required|string',
            'deskripsi' => 'required|string',
            'lokasi_fasilitas' => 'required|string',
            'jenis_fasilitas' => 'required|string',
            'tingkat_urgensi' => 'required|in:Rendah,Sedang,Tinggi',
            'status' => 'required|in:Menunggu,Diproses,Selesai,Ditolak',
            'foto_bukti' => 'nullable|file|mimes:jpeg,png,jpg|max:2048',
            'tanggal_pengaduan' => 'required|date',
            'catatan_admin' => 'nullable|string',
            'catatan_satgas' => 'nullable|string'
        ]);

        if ($request->hasFile('foto_bukti')) {
            if ($kasus->foto_bukti) {
                Storage::delete('public/' . $kasus->foto_bukti);
            }
            
            $file = $request->file('foto_bukti');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->storeAs('public/foto_bukti', $filename);
            $validated['foto_bukti'] = 'foto_bukti/' . $filename;
        }

        if ($validated['status'] === 'Diproses' && !$kasus->tanggal_penanganan) {
            $validated['tanggal_penanganan'] = Carbon::now();
        }

        if ($validated['status'] === 'Selesai' && !$kasus->tanggal_selesai) {
            $validated['tanggal_selesai'] = Carbon::now();
        }

        $kasus->update($validated);
        return redirect()->route('admin.kasus.index')
            ->with('success', 'Data kasus berhasil diperbarui');
    }

    public function destroy($id)
    {
        $kasus = Kasus::findOrFail($id);
        
        if ($kasus->foto_bukti) {
            Storage::delete('public/' . $kasus->foto_bukti);
        }
        
        $kasus->delete();
        return redirect()->route('admin.kasus.index')
            ->with('success', 'Data kasus berhasil dihapus');
    }
} 