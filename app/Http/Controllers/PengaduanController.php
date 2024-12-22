<?php

namespace App\Http\Controllers;

use App\Models\Pelapor;
use App\Models\Kasus;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class PengaduanController extends Controller
{
    public function store(Request $request)
    {
        try {
            // Validasi input
            $request->validate([
                'nama_lengkap' => 'required|string|max:100',
                'nama_panggilan' => 'required|string|max:50',
                'unsur' => 'required|string|max:100',
                'melapor_sebagai' => 'required|string|max:50',
                'bukti_identitas' => 'required|file|mimes:jpeg,png,jpg,pdf|max:2048',
                'fakultas' => 'required|string|max:50',
                'departemen_prodi' => 'nullable|string|max:50',
                'unit_kerja' => 'nullable|string|max:50',
                'email' => 'required|email|max:100',
                'no_wa' => 'required|string|max:15',
                'hubungan_korban' => 'required|string|max:50',
                'jenis_masalah' => 'required|string|in:bullying,kekerasan seksual,pelecehan verbal,diskriminasi,cyberbullying,lainnya',
                'deskripsi_kasus' => 'required|string',
                'bukti_kasus' => 'nullable|file|mimes:jpeg,png,jpg,pdf|max:2048',
                'urgensi' => 'required|in:segera,dalam beberapa hari,tidak mendesak',
                'dampak' => 'required|in:sangat besar,sedang,kecil',
            ]);

            DB::beginTransaction();

            // Proses unsur lainnya
            $unsur = $request->unsur === 'lainnya' ? $request->other : $request->unsur;
            
            // Proses melapor sebagai lainnya
            $melaporSebagai = $request->melapor_sebagai === 'lainnya' ? $request->melapor_other : $request->melapor_sebagai;
            
            // Proses hubungan korban lainnya
            $hubunganKorban = $request->hubungan_korban === 'lainnya' ? $request->hubungan_other : $request->hubungan_korban;

            // Cek pelapor yang sudah ada
            $existingPelapor = Pelapor::where('email', $request->email)->first();

            if ($existingPelapor) {
                // Update pelapor yang ada
                $existingPelapor->update([
                    'nama_lengkap' => $request->nama_lengkap,
                    'nama_panggilan' => $request->nama_panggilan,
                    'unsur' => $unsur,
                    'melapor_sebagai' => $melaporSebagai,
                    'fakultas' => $request->fakultas,
                    'departemen_prodi' => $request->departemen_prodi,
                    'unit_kerja' => $request->unit_kerja,
                    'no_wa' => $request->no_wa,
                    'hubungan_korban' => $hubunganKorban,
                ]);

                if ($request->hasFile('bukti_identitas')) {
                    if ($existingPelapor->bukti_identitas) {
                        Storage::disk('public')->delete($existingPelapor->bukti_identitas);
                    }
                    $buktiIdentitasPath = $request->file('bukti_identitas')->store('bukti_identitas', 'public');
                    $existingPelapor->bukti_identitas = $buktiIdentitasPath;
                    $existingPelapor->save();
                }

                $pelapor = $existingPelapor;
            } else {
                // Buat pelapor baru
                $buktiIdentitasPath = $request->file('bukti_identitas')->store('bukti_identitas', 'public');
                
                $pelapor = Pelapor::create([
                    'nama_lengkap' => $request->nama_lengkap,
                    'nama_panggilan' => $request->nama_panggilan,
                    'unsur' => $unsur,
                    'melapor_sebagai' => $melaporSebagai,
                    'bukti_identitas' => $buktiIdentitasPath,
                    'fakultas' => $request->fakultas,
                    'departemen_prodi' => $request->departemen_prodi,
                    'unit_kerja' => $request->unit_kerja,
                    'email' => $request->email,
                    'no_wa' => $request->no_wa,
                    'hubungan_korban' => $hubunganKorban,
                ]);
            }

            // Proses bukti kasus
            $buktiKasusPath = null;
            if ($request->hasFile('bukti_kasus')) {
                $buktiKasusPath = $request->file('bukti_kasus')->store('bukti_kasus', 'public');
            }

            // Buat kasus baru
            $kasus = Kasus::create([
                'id_pelapor' => $pelapor->id_pelapor,
                'kode_pengaduan' => Kasus::generateKodePengaduan(),
                'jenis_masalah' => $request->jenis_masalah,
                'urgensi' => $request->urgensi,
                'dampak' => $request->dampak,
                'status_pengaduan' => 'perlu dikonfirmasi',
                'tanggal_pengaduan' => now(),
                'deskripsi_kasus' => $request->deskripsi_kasus,
                'bukti_kasus' => $buktiKasusPath,
                'asal_fakultas' => $request->fakultas,
            ]);

            DB::commit();

            return redirect()->route('pengaduan.success')
                ->with('success', 'Pengaduan berhasil diajukan!')
                ->with('kode_pengaduan', $kasus->kode_pengaduan);

        } catch (\Exception $e) {
            DB::rollback();
            Log::error('Error dalam pengaduan: ' . $e->getMessage());
            
            return redirect()->back()
                ->withInput()
                ->withErrors(['error' => 'Terjadi kesalahan: ' . $e->getMessage()]);
        }
    }

    // Tambahkan method untuk menampilkan halaman success
    public function success()
    {
        // Jika tidak ada pesan success di session, redirect ke form
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
            'kode_pengaduan' => 'required|string|size:6'
        ], [
            'kode_pengaduan.required' => 'Kode pengaduan harus diisi',
            'kode_pengaduan.size' => 'Kode pengaduan harus 6 karakter'
        ]);

        $kasus = Kasus::where('kode_pengaduan', $request->kode_pengaduan)->first();

        if (!$kasus) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Kode pengaduan tidak ditemukan');
        }

        // Redirect ke halaman detail status dengan kode pengaduan
        return redirect()->route('pengaduan.detail-status', $kasus->kode_pengaduan);
    }

    public function detailStatus($kode)
    {
        $kasus = Kasus::where('kode_pengaduan', $kode)
            ->with('pelapor') // Load relasi pelapor jika diperlukan
            ->firstOrFail();

        return view('Pelapor.detail_status', compact('kasus'));
    }
}
