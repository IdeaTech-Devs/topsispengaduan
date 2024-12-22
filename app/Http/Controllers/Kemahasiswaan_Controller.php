<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Kasus;
use App\Models\Kemahasiswaan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use App\Models\User;
use App\Models\KriteriaTopsis;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class Kemahasiswaan_Controller extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('role:kemahasiswaan');
    }

    public function dashboard($fakultas = null)
    {
        // Ambil data kemahasiswaan yang sedang login
        $kemahasiswaan = Kemahasiswaan::where('id_kemahasiswaan', Auth::user()->id_kemahasiswaan)->first();
        
        if (!$fakultas) {
            $fakultas = $kemahasiswaan->fakultas;
        }
        
        if ($fakultas != $kemahasiswaan->fakultas) {
            return redirect()->route('kemahasiswaan.dashboard', ['fakultas' => $kemahasiswaan->fakultas]);
        }

        // Menunggu Verifikasi (belum ada relasi dengan kemahasiswaan)
        $pending_count = Kasus::where([
            ['asal_fakultas', '=', $fakultas],
            ['status_pengaduan', '=', 'perlu dikonfirmasi'],
            ['id_kemahasiswaan', '=', null]
        ])->count();

        // Dalam Proses (sudah ada relasi dengan kemahasiswaan)
        $process_count = Kasus::where([
            ['asal_fakultas', '=', $fakultas],
            ['status_pengaduan', '=', 'perlu dikonfirmasi'],
            ['id_kemahasiswaan', '=', $kemahasiswaan->id_kemahasiswaan]
        ])->count();

        // Kasus Selesai (sudah ada relasi dan status sesuai)
        $completed_count = Kasus::where([
            ['asal_fakultas', '=', $fakultas],
            ['id_kemahasiswaan', '=', $kemahasiswaan->id_kemahasiswaan]
        ])
        ->whereIn('status_pengaduan', ['dikonfirmasi', 'ditolak', 'proses satgas', 'selesai'])
        ->count();

        // Total semua kasus
        $total_count = $pending_count + $process_count + $completed_count;

        // Ambil kasus terbaru yang perlu dikonfirmasi
        $recent_cases = Kasus::where([
            ['asal_fakultas', '=', $fakultas],
            ['status_pengaduan', '=', 'perlu dikonfirmasi'],
            ['id_kemahasiswaan', '=', null]
        ])
        ->with('pelapor')
        ->orderBy('created_at', 'desc')
        ->take(5)
        ->get()
        ->map(function($case) {
            $case->status_class = match($case->status_pengaduan) {
                'perlu dikonfirmasi' => 'warning',
                'dikonfirmasi' => 'info',
                'proses satgas' => 'primary',
                'selesai' => 'success',
                'ditolak' => 'danger',
                default => 'secondary'
            };
            return $case;
        });

        return view('kemahasiswaan.dashboard', compact(
            'kemahasiswaan',
            'pending_count',
            'process_count',
            'completed_count',
            'total_count',
            'recent_cases'
        ));
    }

    public function lihatKasus()
    {
        try {
            $kemahasiswaan = Kemahasiswaan::where('id_kemahasiswaan', Auth::user()->id_kemahasiswaan)->first();
            $kriteria = KriteriaTopsis::with('nilaiKriteria')->get();
            
            // Query untuk kasus
            $kasusQuery = Kasus::where([
                ['asal_fakultas', '=', $kemahasiswaan->fakultas],
                ['status_pengaduan', '=', 'perlu dikonfirmasi'],
                ['id_kemahasiswaan', '=', null]
            ])->with('pelapor');
            
            $allKasus = $kasusQuery->get();
            
            // Debug: Cek jumlah kasus
            Log::info('Jumlah kasus ditemukan: ' . $allKasus->count());
            
            $prioritasKasus = [];
            if ($allKasus->isNotEmpty()) {
                // Debug: Sebelum perhitungan TOPSIS
                Log::info('Mulai perhitungan TOPSIS');
                
                $prioritasKasus = $this->hitungTOPSIS($allKasus);
                
                // Debug: Hasil TOPSIS
                Log::info('Hasil TOPSIS:', $prioritasKasus);
                
                if (!empty($prioritasKasus)) {
                    $sortedKasusIds = array_keys($prioritasKasus);
                    $kasus = $kasusQuery->whereIn('id_kasus', $sortedKasusIds)
                                       ->orderByRaw("FIELD(id_kasus, " . implode(',', $sortedKasusIds) . ")")
                                       ->paginate(10);
                    
                    // Debug: Kasus setelah pengurutan
                    Log::info('ID Kasus setelah pengurutan: ' . implode(', ', $kasus->pluck('id_kasus')->toArray()));
                } else {
                    Log::warning('Hasil TOPSIS kosong');
                    $kasus = $kasusQuery->paginate(10);
                }
            } else {
                Log::info('Tidak ada kasus yang ditemukan');
                $kasus = $kasusQuery->paginate(10);
            }
            
            // Debug: Data yang dikirim ke view
            Log::info('Data yang dikirim ke view:', [
                'jumlah_kasus' => $kasus->count(),
                'ada_prioritas' => !empty($prioritasKasus),
                'jumlah_kriteria' => $kriteria->count()
            ]);
            
            return view('kemahasiswaan.lihat_kasus', compact('kasus', 'kemahasiswaan', 'prioritasKasus', 'kriteria'));
            
        } catch (\Exception $e) {
            Log::error('Error in lihatKasus: ' . $e->getMessage());
            Log::error('Stack trace: ' . $e->getTraceAsString());
            return back()->with('error', 'Terjadi kesalahan saat memuat data kasus');
        }
    }

    private function hitungTOPSIS($kasus)
    {
        // Ambil kriteria dan bobot dari database
        $kriteria = KriteriaTopsis::with('nilaiKriteria')->get();
        
        // Debug untuk melihat data kasus
        foreach ($kasus as $k) {
            Log::info("Data Kasus ID {$k->id_kasus}:", [
                'jenis_masalah' => $k->jenis_masalah,
                'urgensi' => $k->urgensi,
                'dampak' => $k->dampak,
                'unsur_terlapor' => $k->pelapor->unsur,
                'bukti' => $k->bukti_kasus ? 'ada bukti' : 'tidak ada bukti'
            ]);
        }
        
        // Inisialisasi matriks keputusan
        $matriks = [];
        foreach ($kasus as $k) {
            $row = [];
            foreach ($kriteria as $krit) {
                switch ($krit->nama_kriteria) {
                    case 'jenis_masalah':
                        $nilai = $this->getNilaiKriteria($krit, strtolower($k->jenis_masalah));
                        break;
                    
                    case 'urgensi':
                        $nilai = $this->getNilaiKriteria($krit, strtolower($k->urgensi));
                        // Tambah nilai berdasarkan waktu untuk kasus tidak mendesak
                        if (in_array(strtolower($k->urgensi), ['dalam beberapa hari', 'tidak mendesak'])) {
                            $daysDiff = now()->diffInDays($k->tanggal_pengaduan);
                            if ($daysDiff > 7) { // Jika lebih dari seminggu
                                $nilai += 1; // Tambah 1 poin
                            }
                        }
                        break;
                    
                    case 'dampak':
                        $nilai = $this->getNilaiKriteria($krit, strtolower($k->dampak));
                        break;
                    
                    case 'unsur':
                        $nilai = $this->getNilaiKriteria($krit, strtolower($k->pelapor->unsur));
                        break;
                    
                    case 'bukti':
                        $nilai = $this->getNilaiKriteria($krit, $k->bukti_kasus ? 'ada bukti' : 'tidak ada bukti');
                        break;
                
                    default:
                        $nilai = 0;
                        break;
                }
                
                Log::info("Kasus {$k->id_kasus} - {$krit->nama_kriteria}: {$nilai}");
                $row[] = $nilai;
            }
            $matriks[$k->id_kasus] = $row;
        }
        
        if (empty($matriks)) {
            Log::warning('Matriks kosong, tidak ada data valid untuk dihitung');
            return [];
        }
        
        // Normalisasi matriks
        $normalizedMatrix = $this->normalizeMatrix($matriks);
        
        // Hitung matriks terbobot
        $weightedMatrix = $this->calculateWeightedMatrix($normalizedMatrix, $kriteria);
        
        // Tentukan solusi ideal
        $idealSolutions = $this->findIdealSolutions($weightedMatrix, $kriteria);
        
        // Hitung preferensi
        $preferences = $this->calculatePreferences($weightedMatrix, $idealSolutions);
        
        Log::info('Hasil Akhir TOPSIS:', $preferences);
        
        return $preferences;
    }

    private function calculatePreferences($weightedMatrix, $idealSolutions)
    {
        $preferences = [];
        
        foreach ($weightedMatrix as $kasusId => $row) {
            $positiveDistance = 0;
            $negativeDistance = 0;
            
            // Hitung jarak ke solusi ideal positif dan negatif
            for ($i = 0; $i < count($row); $i++) {
                $positiveDistance += pow($row[$i] - $idealSolutions['positive'][$i], 2);
                $negativeDistance += pow($row[$i] - $idealSolutions['negative'][$i], 2);
            }
            
            $positiveDistance = sqrt($positiveDistance);
            $negativeDistance = sqrt($negativeDistance);
            
            // Hitung nilai preferensi
            $totalDistance = $positiveDistance + $negativeDistance;
            
            if ($totalDistance == 0) {
                $preferences[$kasusId] = 0.5; // Nilai default jika tidak ada perbedaan
            } else {
                // Rumus TOPSIS: Si = Di- / (Di+ + Di-)
                $preferences[$kasusId] = $negativeDistance / $totalDistance;
            }
            
            // Log detail perhitungan
            Log::info("Kasus {$kasusId} - Detail perhitungan:", [
                'nilai_terbobot' => $row,
                'jarak_positif' => $positiveDistance,
                'jarak_negatif' => $negativeDistance,
                'total_jarak' => $totalDistance,
                'skor_final' => $preferences[$kasusId]
            ]);
        }
        
        arsort($preferences);
        return $preferences;
    }

    public function kelolaKasus()
    {
        $kemahasiswaan = Kemahasiswaan::where('id_kemahasiswaan', Auth::user()->id_kemahasiswaan)->first();
        
        // Ambil kasus yang berelasi dengan kemahasiswaan ini dan status 'perlu dikonfirmasi'
        $kasus = Kasus::where('id_kemahasiswaan', $kemahasiswaan->id_kemahasiswaan)
                     ->where('status_pengaduan', 'perlu dikonfirmasi')
                     ->with('pelapor')
                     ->orderBy('created_at', 'desc')
                     ->paginate(10);
        
        return view('kemahasiswaan.kelola_kasus', compact('kasus', 'kemahasiswaan'));
    }

    public function updateStatus(Request $request, $id)
    {
        $kasus = Kasus::findOrFail($id);
        
        // Pastikan kemahasiswaan hanya bisa update kasus dari fakultasnya
        $kemahasiswaan = Kemahasiswaan::where('id_kemahasiswaan', Auth::user()->id_kemahasiswaan)->first();
        
        if ($kasus->asal_fakultas !== $kemahasiswaan->fakultas) {
            return back()->with('error', 'Anda tidak memiliki akses untuk mengubah kasus ini');
        }

        // Logika update bisa disesuaikan dengan kebutuhan
        $kasus->update([
            'keterangan' => $request->keterangan
        ]);

        return back()->with('success', 'Kasus berhasil diperbarui');
    }

    public function detailKasus($id)
    {
        $kemahasiswaan = Kemahasiswaan::where('id_kemahasiswaan', Auth::user()->id_kemahasiswaan)->first();
        $kasus = Kasus::with('pelapor')->findOrFail($id);
        
        return view('kemahasiswaan.detail_kasus', compact('kasus', 'kemahasiswaan'));
    }

    public function profil()
    {
        $kemahasiswaan = Kemahasiswaan::where('id_kemahasiswaan', Auth::user()->id_kemahasiswaan)->first();
        return view('kemahasiswaan.profil', compact('kemahasiswaan'));
    }

    public function updateProfil(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:100',
            'email' => 'required|email|unique:users,email,' . auth()->id(),
            'telepon' => 'required|string|max:15',
            'fakultas' => 'required|in:Teknik,Hukum,Pertanian,Ilmu Sosial dan Ilmu Politik,Keguruan dan Ilmu Pendidikan,Ekonomi dan Bisnis,Kedokteran dan Ilmu Kesehatan,Matematika dan Ilmu Pengetahuan Alam',
            'foto_profil' => 'nullable|image|mimes:jpeg,png,jpg|max:2048'
        ]);

        try {
            DB::beginTransaction();

            // Update data di tabel users
            $user = auth()->user();
            $user->email = $request->email;
            $user->save();

            // Update data di tabel kemahasiswaan
            $kemahasiswaan = Kemahasiswaan::find($user->id_kemahasiswaan);
            $kemahasiswaan->nama = $request->nama;
            $kemahasiswaan->telepon = $request->telepon;
            $kemahasiswaan->fakultas = $request->fakultas;

            // Handle foto profil
            if ($request->hasFile('foto_profil')) {
                // Hapus foto lama jika ada
                if ($kemahasiswaan->foto_profil) {
                    Storage::delete('public/' . $kemahasiswaan->foto_profil);
                }
                
                // Simpan foto baru
                $path = $request->file('foto_profil')->store('profil/kemahasiswaan', 'public');
                $kemahasiswaan->foto_profil = $path;
            }

            $kemahasiswaan->save();

            DB::commit();
            return redirect()->route('kemahasiswaan.profil')
                            ->with('success', 'Profil berhasil diperbarui');

        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->route('kemahasiswaan.profil')
                            ->with('error', 'Terjadi kesalahan saat memperbarui profil');
        }
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $user = auth()->user();

        // Cek password lama
        if (!Hash::check($request->current_password, $user->password)) {
            return back()->withErrors([
                'current_password' => 'Password lama tidak sesuai'
            ]);
        }

        // Update password
        $user->password = Hash::make($request->password);
        $user->save();

        return redirect()->route('kemahasiswaan.profil')
                        ->with('success', 'Password berhasil diperbarui');
    }

    public function evaluasiKasus(Request $request, $id)
    {
        $kemahasiswaan = Kemahasiswaan::where('id_kemahasiswaan', Auth::user()->id_kemahasiswaan)->first();
        $kasus = Kasus::findOrFail($id);
        
        // Hanya update relasi dengan kemahasiswaan
        $kasus->update([
            'id_kemahasiswaan' => $kemahasiswaan->id_kemahasiswaan,
        ]);

        return redirect()->route('kemahasiswaan.kelola_kasus')
                        ->with('success', 'Kasus berhasil ditambahkan ke daftar kelola');
    }

    public function verifikasiKasus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:dikonfirmasi,ditolak',
            'keterangan' => 'required|string'
        ]);

        $kasus = Kasus::findOrFail($id);
        $kemahasiswaan = Kemahasiswaan::where('id_kemahasiswaan', Auth::user()->id_kemahasiswaan)->first();
        
        // Format catatan penanganan
        $catatan = sprintf(
            "%s (%s): %s",
            $kemahasiswaan->nama,
            $request->status == 'dikonfirmasi' ? 'menerima' : 'menolak',
            $request->keterangan
        );
        
        // Debug untuk memastikan data yang akan diupdate
        Log::info('Updating kasus with data:', [
            'status_pengaduan' => $request->status,
            'catatan_penanganan' => $catatan,
            'tanggal_konfirmasi' => now(),
            'penangan_kasus' => $kemahasiswaan->nama
        ]);
        
        try {
            $kasus->update([
                'status_pengaduan' => $request->status,
                'catatan_penanganan' => $catatan,
                'tanggal_konfirmasi' => now(),
                'penangan_kasus' => $kemahasiswaan->nama
            ]);
            
            Log::info('Kasus updated successfully');
            return back()->with('success', 'Status kasus berhasil diperbarui');
        } catch (\Exception $e) {
            Log::error('Error updating kasus: ' . $e->getMessage());
            return back()->with('error', 'Terjadi kesalahan saat memperbarui status kasus');
        }
    }

    public function kasusSelesai()
    {
        $kemahasiswaan = Kemahasiswaan::where('id_kemahasiswaan', Auth::user()->id_kemahasiswaan)->first();
        
        // Ambil kasus yang dikonfirmasi dan dalam proses
        $kasusKonfirmasi = Kasus::where('id_kemahasiswaan', $kemahasiswaan->id_kemahasiswaan)
            ->whereIn('status_pengaduan', ['dikonfirmasi', 'proses satgas', 'selesai'])
            ->with('pelapor')
            ->orderBy('tanggal_konfirmasi', 'desc')
            ->get();
        
        // Ambil kasus yang ditolak
        $kasusDitolak = Kasus::where('id_kemahasiswaan', $kemahasiswaan->id_kemahasiswaan)
            ->where('status_pengaduan', 'ditolak')
            ->with('pelapor')
            ->orderBy('tanggal_konfirmasi', 'desc')
            ->get();
        
        return view('kemahasiswaan.kasus_selesai', compact('kasusKonfirmasi', 'kasusDitolak', 'kemahasiswaan'));
    }

    public function evaluasiUlang(Request $request, $id)
    {
        $request->validate([
            'catatan' => 'required|string'
        ]);

        $kasus = Kasus::findOrFail($id);
        $kemahasiswaan = Kemahasiswaan::where('id_kemahasiswaan', Auth::user()->id_kemahasiswaan)->first();
        
        // Format catatan evaluasi ulang
        $catatan = sprintf(
            "%s (evaluasi ulang): %s",
            $kemahasiswaan->nama,
            $request->catatan
        );
        
        try {
            $kasus->update([
                'status_pengaduan' => 'perlu dikonfirmasi',
                'catatan_penanganan' => $catatan,
                'tanggal_konfirmasi' => null,
                'penangan_kasus' => $kemahasiswaan->nama
            ]);
            
            Log::info('Kasus evaluated successfully');
            return redirect()->route('kemahasiswaan.kasus_selesai')
                            ->with('success', 'Kasus berhasil dievaluasi ulang');
        } catch (\Exception $e) {
            Log::error('Error evaluating kasus: ' . $e->getMessage());
            return back()->with('error', 'Terjadi kesalahan saat mengevaluasi ulang kasus');
        }
    }

    private function getNilaiKriteria($kriteria, $item)
    {
        // Cari nilai yang sesuai
        $nilaiKriteria = $kriteria->nilaiKriteria
            ->where('item', strtolower($item))
            ->first();
        
        // Jika tidak ditemukan, gunakan nilai 'lainnya'
        if (!$nilaiKriteria) {
            $nilaiKriteria = $kriteria->nilaiKriteria
                ->where('item', 'lainnya')
                ->first();
        }
        
        return $nilaiKriteria ? $nilaiKriteria->nilai : 0;
    }

    private function normalizeMatrix($matrix)
    {
        $normalizedMatrix = [];
        $columnCount = count(reset($matrix));
        
        // Hitung akar jumlah kuadrat setiap kolom
        $sumSquares = array_fill(0, $columnCount, 0);
        foreach ($matrix as $row) {
            for ($i = 0; $i < $columnCount; $i++) {
                $sumSquares[$i] += pow($row[$i], 2);
            }
        }
        
        // Normalisasi setiap elemen
        foreach ($matrix as $kasusId => $row) {
            $normalizedRow = [];
            for ($i = 0; $i < $columnCount; $i++) {
                $normalizedRow[] = $sumSquares[$i] ? $row[$i] / sqrt($sumSquares[$i]) : 0;
            }
            $normalizedMatrix[$kasusId] = $normalizedRow;
        }
        
        return $normalizedMatrix;
    }

    private function calculateWeightedMatrix($normalizedMatrix, $kriteria)
    {
        $weightedMatrix = [];
        $weights = $kriteria->pluck('bobot')->toArray();
        
        Log::info("Bobot kriteria:", $weights);
        
        foreach ($normalizedMatrix as $kasusId => $row) {
            $weightedRow = [];
            for ($i = 0; $i < count($row); $i++) {
                $weightedRow[] = $row[$i] * floatval($weights[$i]);
            }
            $weightedMatrix[$kasusId] = $weightedRow;
            
            Log::info("Kasus {$kasusId} - Nilai terbobot:", $weightedRow);
        }
        
        return $weightedMatrix;
    }

    private function findIdealSolutions($weightedMatrix, $kriteria)
    {
        $columnCount = count(reset($weightedMatrix));
        $positiveIdeal = array_fill(0, $columnCount, PHP_FLOAT_MIN);
        $negativeIdeal = array_fill(0, $columnCount, PHP_FLOAT_MAX);
        
        foreach ($weightedMatrix as $row) {
            for ($i = 0; $i < $columnCount; $i++) {
                $isBenefit = $kriteria[$i]->jenis === 'benefit';
                
                if ($isBenefit) {
                    $positiveIdeal[$i] = max($positiveIdeal[$i], $row[$i]);
                    $negativeIdeal[$i] = min($negativeIdeal[$i], $row[$i]);
                } else {
                    $positiveIdeal[$i] = min($positiveIdeal[$i], $row[$i]);
                    $negativeIdeal[$i] = max($negativeIdeal[$i], $row[$i]);
                }
            }
        }
        
        return [
            'positive' => $positiveIdeal,
            'negative' => $negativeIdeal
        ];
    }
}
