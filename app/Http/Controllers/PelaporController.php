<?php

namespace App\Http\Controllers;

use App\Models\Pelapor;
use App\Models\Kasus;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PelaporController extends Controller
{
    public function dashboard()
    {
        return view('pelapor.dashboard');
    }

    public function ajukanPengaduan()
    {
        return view('pelapor.ajukan_pengaduan');
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
            'unsur' => 'required|string',
            'email' => 'required|email',
            'no_wa' => 'required|string|max:15',
            'bukti_identitas' => 'required|file|mimes:jpeg,png,jpg,pdf|max:2048',
            'melapor_sebagai' => 'required|string',
            'hubungan_korban' => 'required|string',
            'jenis_masalah' => 'required|string|in:bullying,kekerasan seksual,pelecehan verbal,diskriminasi,cyberbullying,lainnya',
            'deskripsi_kasus' => 'required|string',
            'urgensi' => 'required|string|in:segera,dalam beberapa hari,tidak mendesak',
            'dampak' => 'required|string|in:sangat besar,sedang,kecil',
            'fakultas' => 'required|string',
            'bukti_kasus' => 'nullable|file|mimes:jpeg,png,jpg,pdf|max:2048',
        ]);

        try {
            // Upload bukti identitas
            $buktiIdentitasPath = $request->file('bukti_identitas')->store('bukti_identitas', 'public');
            
            // Upload bukti kasus jika ada
            $buktiKasusPath = null;
            if ($request->hasFile('bukti_kasus')) {
                $buktiKasusPath = $request->file('bukti_kasus')->store('bukti_kasus', 'public');
            }

            // Buat pelapor baru
            $pelapor = Pelapor::create([
                'nama_lengkap' => $request->nama_lengkap,
                'nama_panggilan' => $request->nama_panggilan,
                'unsur' => $request->unsur === 'lainnya' ? $request->other : $request->unsur,
                'email' => $request->email,
                'no_hp' => $request->no_wa,
                'bukti_identitas' => $buktiIdentitasPath,
                'departemen_prodi' => $request->departemen_prodi,
                'unit_kerja' => $request->unit_kerja,
            ]);

            // Generate kode pengaduan
            $kodePengaduan = 'P' . date('Ymd') . Str::padLeft(Kasus::count() + 1, 4, '0');

            // Buat kasus baru
            $kasus = Kasus::create([
                'id_pelapor' => $pelapor->id_pelapor,
                'kode_pengaduan' => $kodePengaduan,
                'jenis_masalah' => $request->jenis_masalah,
                'deskripsi_kasus' => $request->deskripsi_kasus,
                'urgensi' => $request->urgensi,
                'dampak' => $request->dampak,
                'status_pengaduan' => 'perlu dikonfirmasi',
                'tanggal_pengaduan' => now(),
                'asal_fakultas' => $request->fakultas,
                'bukti_kasus' => $buktiKasusPath,
                'melapor_sebagai' => $request->melapor_sebagai === 'lainnya' ? $request->melapor_other : $request->melapor_sebagai,
                'hubungan_korban' => $request->hubungan_korban === 'lainnya' ? $request->hubungan_other : $request->hubungan_korban,
            ]);

            return redirect()->route('pelapor.dashboard')
                ->with('success', 'Pengaduan berhasil diajukan dengan kode: ' . $kodePengaduan);

        } catch (\Exception $e) {
            return back()->with('error', 'Terjadi kesalahan saat mengajukan pengaduan. Silakan coba lagi.')
                ->withInput();
        }
    }
}
