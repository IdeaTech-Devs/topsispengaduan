<?php

namespace App\Http\Controllers;

use App\Models\Pelapor;
use App\Models\Kasus;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

class PengaduanController extends Controller
{
    public function create()
    {
        return view('Pelapor.ajukan_pengaduan');
    }

    public function store(Request $request)
    {
        try {
            // Validasi input
            $request->validate([
                'nama_lengkap' => 'required|string|max:100',
                'nama_panggilan' => 'required|string|max:50',
                'email' => 'required|email|max:100',
                'no_wa' => 'required|string|max:15',
                'judul_pengaduan' => 'required|string|max:255',
                'deskripsi' => 'required|string',
                'lokasi_fasilitas' => 'required|string|max:255',
                'jenis_fasilitas' => 'required|string|max:255',
                'tingkat_urgensi' => 'required|in:Rendah,Sedang,Tinggi',
                'foto_bukti' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            ]);

            DB::beginTransaction();

            // Cek pelapor yang sudah ada
            $existingPelapor = Pelapor::where('email', $request->email)->first();

            if ($existingPelapor) {
                $existingPelapor->update([
                    'nama_lengkap' => $request->nama_lengkap,
                    'nama_panggilan' => $request->nama_panggilan,
                    'no_wa' => $request->no_wa,
                ]);
                $pelapor = $existingPelapor;
            } else {
                $pelapor = Pelapor::create([
                    'nama_lengkap' => $request->nama_lengkap,
                    'nama_panggilan' => $request->nama_panggilan,
                    'email' => $request->email,
                    'no_wa' => $request->no_wa,
                ]);
                if (!$pelapor) {
                    throw new \Exception('Gagal membuat pelapor, data tidak lengkap.');
                }
            }

            // Upload foto bukti
            $foto_bukti = $request->file('foto_bukti')->store('public/foto_bukti');
            $foto_bukti = str_replace('public/', '', $foto_bukti);

            // Buat pengaduan baru
            $kasus = Kasus::create([
                'pelapor_id' => $pelapor->id_pelapor,
                'no_pengaduan' => 'FAC' . str_pad(Kasus::count() + 1, 3, '0', STR_PAD_LEFT),
                'judul_pengaduan' => $request->judul_pengaduan,
                'deskripsi' => $request->deskripsi,
                'lokasi_fasilitas' => $request->lokasi_fasilitas,
                'jenis_fasilitas' => $request->jenis_fasilitas,
                'tingkat_urgensi' => $request->tingkat_urgensi,
                'status' => 'Menunggu',
                'foto_bukti' => $foto_bukti,
                'tanggal_pengaduan' => Carbon::now()
            ]);

            DB::commit();

            return redirect()->route('pengaduan.success')
                ->with('success', 'Pengaduan fasilitas berhasil diajukan!')
                ->with('no_pengaduan', $kasus->no_pengaduan);

        } catch (\Exception $e) {
            DB::rollback();
            Log::error('Error dalam pengaduan: ' . $e->getMessage());
            
            return redirect()->back()
                ->withInput()
                ->withErrors(['error' => 'Terjadi kesalahan: ' . $e->getMessage()]);
        }
    }

    public function success()
    {
        if (!session('success')) {
            return redirect()->route('pengaduan.create');
        }
        
        return view('Pelapor.pengaduan_success');
    }

    public function lihatProgres()
    {
        return view('Pelapor.lihat_progres');
    }

    public function cekStatus(Request $request)
    {
        $request->validate([
            'no_pengaduan' => 'required|string'
        ], [
            'no_pengaduan.required' => 'Nomor pengaduan harus diisi'
        ]);

        $kasus = Kasus::where('no_pengaduan', $request->no_pengaduan)->first();

        if (!$kasus) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Nomor pengaduan tidak ditemukan');
        }

        return redirect()->route('pengaduan.detail-status', $kasus->no_pengaduan);
    }

    public function detailStatus($nomor)
    {
        $kasus = Kasus::where('no_pengaduan', $nomor)
            ->with(['pelapor', 'satgas', 'kasusSatgas'])
            ->firstOrFail();

        return view('Pelapor.detail_status', compact('kasus'));
    }
}
