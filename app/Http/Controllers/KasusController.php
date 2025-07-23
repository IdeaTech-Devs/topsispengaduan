<?php

namespace App\Http\Controllers;

use App\Models\Kasus;
use App\Models\Pelapor;
use App\Models\Satgas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

class KasusController extends Controller
{
    public function create()
    {
        return view('kasus.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'judul_pengaduan' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'lokasi_fasilitas' => 'required|string|max:255',
            'jenis_fasilitas' => 'required|string|max:255',
            'tingkat_urgensi' => 'required|in:Rendah,Sedang,Tinggi',
            'foto_bukti' => 'required|image|mimes:jpeg,png,jpg|max:2048'
        ]);

        $foto_bukti = null;
        if ($request->hasFile('foto_bukti')) {
            $foto_bukti = $request->file('foto_bukti')->store('public/foto_bukti');
            $foto_bukti = str_replace('public/', '', $foto_bukti);
        }

        $kasus = Kasus::create([
            'pelapor_id' => auth()->user()->pelapor->id,
            'no_pengaduan' => 'FAC' . date('Ymd') . str_pad(Kasus::count() + 1, 3, '0', STR_PAD_LEFT),
            'judul_pengaduan' => $request->judul_pengaduan,
            'deskripsi' => $request->deskripsi,
            'lokasi_fasilitas' => $request->lokasi_fasilitas,
            'jenis_fasilitas' => $request->jenis_fasilitas,
            'tingkat_urgensi' => $request->tingkat_urgensi,
            'status' => 'Menunggu',
            'foto_bukti' => $foto_bukti,
            'tanggal_pengaduan' => Carbon::now()
        ]);

        return redirect()->route('kasus.show', $kasus->id)->with('success', 'Pengaduan fasilitas berhasil dibuat.');
    }

    public function index()
    {
        $kasus = Kasus::with(['pelapor', 'satgas'])->latest()->get();
        return view('kasus.index', compact('kasus'));
    }

    public function show($id)
    {
        $kasus = Kasus::with(['pelapor', 'satgas', 'kasusSatgas'])->findOrFail($id);
        $satgas = Satgas::all();
        return view('kasus.show', compact('kasus', 'satgas'));
    }

    public function edit($id)
    {
        $kasus = Kasus::findOrFail($id);
        return view('kasus.edit', compact('kasus'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'judul_pengaduan' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'lokasi_fasilitas' => 'required|string|max:255',
            'jenis_fasilitas' => 'required|string|max:255',
            'tingkat_urgensi' => 'required|in:Rendah,Sedang,Tinggi',
            'foto_bukti' => 'nullable|image|mimes:jpeg,png,jpg|max:2048'
        ]);

        $kasus = Kasus::findOrFail($id);

        if ($request->hasFile('foto_bukti')) {
            // Hapus foto lama jika ada
            if ($kasus->foto_bukti) {
                Storage::delete('public/' . $kasus->foto_bukti);
            }
            
            $foto_bukti = $request->file('foto_bukti')->store('public/foto_bukti');
            $foto_bukti = str_replace('public/', '', $foto_bukti);
            $kasus->foto_bukti = $foto_bukti;
        }

        $kasus->update([
            'judul_pengaduan' => $request->judul_pengaduan,
            'deskripsi' => $request->deskripsi,
            'lokasi_fasilitas' => $request->lokasi_fasilitas,
            'jenis_fasilitas' => $request->jenis_fasilitas,
            'tingkat_urgensi' => $request->tingkat_urgensi
        ]);

        return redirect()->route('kasus.show', $kasus->id)->with('success', 'Pengaduan fasilitas berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $kasus = Kasus::findOrFail($id);
        
        // Hapus foto jika ada
        if ($kasus->foto_bukti) {
            Storage::delete('public/' . $kasus->foto_bukti);
        }
        if ($kasus->foto_penanganan) {
            Storage::delete('public/' . $kasus->foto_penanganan);
        }
        
        $kasus->delete();

        return redirect()->route('kasus.index')->with('success', 'Pengaduan fasilitas berhasil dihapus.');
    }

    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:Menunggu,Diproses,Selesai,Ditolak',
            'catatan_admin' => 'nullable|string'
        ]);

        $kasus = Kasus::findOrFail($id);
        $kasus->status = $request->status;
        $kasus->catatan_admin = $request->catatan_admin;
        
        if ($request->status === 'Diproses') {
            $kasus->tanggal_penanganan = Carbon::now();
        } elseif ($request->status === 'Selesai') {
            $kasus->tanggal_selesai = Carbon::now();
        }
        
        $kasus->save();

        return redirect()->route('kasus.show', $id)->with('success', 'Status pengaduan berhasil diperbarui.');
    }
}
