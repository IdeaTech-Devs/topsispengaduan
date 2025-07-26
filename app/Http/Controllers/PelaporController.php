<?php

namespace App\Http\Controllers;

use App\Models\Pelapor;
use App\Models\Kasus;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\Ruang;
use App\Models\Fasilitas;

class PelaporController extends Controller
{
    public function dashboard()
    {
        return view('pelapor.dashboard');
    }

    public function ajukanPengaduan()
    {
        $ruang = Ruang::orderBy('nama_ruang')->get();
        $jenisFasilitas = Fasilitas::select('jenis_fasilitas')->distinct()->pluck('jenis_fasilitas');
        return view('pelapor.ajukan_pengaduan', compact('ruang', 'jenisFasilitas'));
    }

    public function lihatProgres()
    {
        return view('pelapor.lihat_progres');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_lengkap' => 'required|string|max:100',
            'nama_panggilan' => 'required|string|max:50',
            'status_pelapor' => 'required|in:staff,pengunjung',
            'email' => 'required|email|max:100',
            'no_wa' => 'required|string|max:15',
            'judul_pengaduan' => 'required|string|max:255',
            'lokasi_fasilitas' => 'required|string',
            'jenis_fasilitas' => 'required|string',
            'deskripsi_pengaduan' => 'required|string',
            'tingkat_urgensi' => 'required|in:tinggi,sedang,rendah',
            'foto_bukti' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        try {
            // Upload foto bukti
            $fotoBuktiPath = $request->file('foto_bukti')->store('foto_bukti', 'public');
            
            // Buat pelapor baru
            $pelapor = Pelapor::create([
                'nama_lengkap' => $request->nama_lengkap,
                'nama_panggilan' => $request->nama_panggilan,
                'status_pelapor' => $request->status_pelapor,
                'email' => $request->email,
                'no_wa' => $request->no_wa
            ]);

            // Generate kode pengaduan
            $kodePengaduan = 'P' . date('Ymd') . Str::padLeft(Kasus::count() + 1, 4, '0');

            // Buat kasus baru
            $kasus = Kasus::create([
                'pelapor_id' => $pelapor->id_pelapor,
                'no_pengaduan' => $kodePengaduan,
                'judul_pengaduan' => $request->judul_pengaduan,
                'lokasi_fasilitas' => $request->lokasi_fasilitas,
                'jenis_fasilitas' => $request->jenis_fasilitas,
                'deskripsi' => $request->deskripsi_pengaduan,
                'tingkat_urgensi' => $request->tingkat_urgensi,
                'foto_bukti' => $fotoBuktiPath,
                'status' => 'Menunggu',
                'tanggal_pengaduan' => now()
            ]);

            return redirect()->route('pelapor.dashboard')
                ->with('success', 'Pengaduan berhasil diajukan dengan kode: ' . $kodePengaduan);

        } catch (\Exception $e) {
            return back()->with('error', 'Terjadi kesalahan saat mengajukan pengaduan. Silakan coba lagi.')
                ->withInput();
        }
    }
}
