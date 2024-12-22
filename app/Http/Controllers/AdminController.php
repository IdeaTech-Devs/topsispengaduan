<?php

namespace App\Http\Controllers;

use App\Models\Kasus;
use App\Models\Satgas;
use App\Models\Kemahasiswaan;
use App\Models\Pelapor;
use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;

class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('role:admin');

        // Share admin data ke semua view yang menggunakan layout admin
        View::composer('admin.*', function($view) {
            if (Auth::check()) {
                // Cari atau buat admin berdasarkan email user yang login
                $admin = Admin::firstOrCreate(
                    ['email' => Auth::user()->email],
                    [
                        'nama' => Auth::user()->email, // default nama menggunakan email
                        'telepon' => '',
                        'foto_profil' => null
                    ]
                );
                
                // Update relasi user dengan admin jika belum ada
                if (!Auth::user()->id_admin) {
                    Auth::user()->update(['id_admin' => $admin->id_admin]);
                }
                
                $view->with([
                    'admin' => $admin,
                    'nama_admin' => $admin->nama ?? Auth::user()->email,
                    'foto_admin' => $admin->foto_profil ? asset('storage/'.$admin->foto_profil) : asset('assets/img/undraw_profile.svg')
                ]);
            }
        });
    }

    public function dashboard()
    {
        // Hitung semua kasus
        $semuaKasusCount = Kasus::count();

        // Hitung kasus belum selesai (semua status kecuali 'selesai')
        $kasusBelumSelesaiCount = Kasus::whereIn('status_pengaduan', [
            'perlu dikonfirmasi',
            'dikonfirmasi',
            'ditolak',
            'proses satgas'
        ])->count();

        // Hitung kasus selesai
        $kasusSelesaiCount = Kasus::where('status_pengaduan', 'selesai')->count();

        // Hitung total Satgas dan Kemahasiswaan
        $totalSatgas = Satgas::count();
        $totalKemahasiswaan = Kemahasiswaan::count();

        // Ambil data kasus terbaru
        $kasusTerbaru = Kasus::with('pelapor')
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        return view('admin.dashboard', compact(
            'semuaKasusCount',
            'kasusBelumSelesaiCount',
            'kasusSelesaiCount',
            'totalSatgas',
            'totalKemahasiswaan',
            'kasusTerbaru'
        ));
    }

    public function profil()
    {
        // Cari atau buat admin berdasarkan email user yang login
        $admin = Admin::firstOrCreate(
            ['email' => Auth::user()->email],
            [
                'nama' => '',
                'telepon' => ''
            ]
        );
        
        return view('admin.profil', compact('admin'));
    }

    public function kasusBelumSelesai()
    {
        $kasusBelumSelesai = Kasus::with(['pelapor', 'satgas'])
            ->whereIn('status_pengaduan', ['dikonfirmasi', 'proses satgas'])
            ->orderBy('created_at', 'desc')
            ->get();

        $satgasList = Satgas::withCount(['kasus as kasus_aktif_count' => function($query) {
            $query->whereHas('kasus_satgas', function($q) {
                $q->where('status_tindak_lanjut', 'proses');
            });
        }])->get();

        $satgasList->each(function($satgas) {
            $kasus_aktif = $satgas->kasus()
                ->whereHas('kasus_satgas', function($q) {
                    $q->where('status_tindak_lanjut', 'proses');
                })
                ->pluck('kode_pengaduan')
                ->implode(', ');
            $satgas->kasus_aktif_list = $kasus_aktif;
        });

        return view('admin.tindak_lanjut.belum_selesai', compact('kasusBelumSelesai', 'satgasList'));
    }

    public function kasusSelesai()
    {
        $kasusSelesai = Kasus::with(['pelapor', 'kemahasiswaan'])
            ->where('status_pengaduan', 'selesai')
            ->orderBy('updated_at', 'desc')
            ->get();

        return view('admin.tindak_lanjut.selesai', compact('kasusSelesai'));
    }

    public function detailKasus($id)
    {
        $kasus = Kasus::with(['pelapor', 'kemahasiswaan', 'satgas'])
            ->findOrFail($id);
            
        return view('admin.tindak_lanjut.detail_kasus', compact('kasus'));
    }

    public function updateStatus(Request $request, $id)
    {
        $kasus = Kasus::findOrFail($id);
        
        $validated = $request->validate([
            'status_pengaduan' => 'required|in:perlu dikonfirmasi,proses satgas,selesai,ditolak',
            'catatan_penanganan' => 'nullable|string',
            'penangan_kasus' => 'required_if:status_pengaduan,selesai'
        ]);

        // Update kasus
        $kasus->update($validated);

        // Jika status diubah menjadi selesai, update juga kasus_satgas
        if ($request->status_pengaduan === 'selesai') {
            foreach($kasus->satgas as $satgas) {
                $kasus->satgas()->updateExistingPivot($satgas->id_satgas, [
                    'status_tindak_lanjut' => 'selesai',
                    'tanggal_tindak_selesai' => now()
                ]);
            }
        }

        return redirect()->back()
            ->with('success', 'Status kasus berhasil diperbarui');
    }

    public function assignSatgas(Request $request, $id_kasus)
    {
        $kasus = Kasus::findOrFail($id_kasus);
        $satgas_ids = $request->satgas_ids;

        foreach($satgas_ids as $satgas_id) {
            $kasus->satgas()->attach($satgas_id, [
                'tanggal_tindak_lanjut' => now(),
                'status_tindak_lanjut' => 'proses'
            ]);
        }

        $kasus->update([
            'status_pengaduan' => 'proses satgas'
        ]);

        return redirect()->back()->with('success', 'Petugas berhasil ditugaskan');
    }

    public function updateProfil(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:100',
            'telepon' => 'required|string|max:15',
            'foto_profil' => 'nullable|image|mimes:jpeg,png,jpg|max:2048'
        ]);

        try {
            DB::beginTransaction();

            // Cari admin berdasarkan email
            $admin = Admin::where('email', Auth::user()->email)->first();
            
            if (!$admin) {
                throw new \Exception('Data admin tidak ditemukan');
            }

            // Update data admin
            $admin->nama = $request->nama;
            $admin->telepon = $request->telepon;

            // Handle foto profil
            if ($request->hasFile('foto_profil')) {
                // Hapus foto lama jika ada
                if ($admin->foto_profil && Storage::exists('public/' . $admin->foto_profil)) {
                    Storage::delete('public/' . $admin->foto_profil);
                }
                
                // Simpan foto baru
                $path = $request->file('foto_profil')->store('profil/admin', 'public');
                $admin->foto_profil = $path;
            }

            $admin->save();

            DB::commit();
            return redirect()->route('admin.profil')
                            ->with('success', 'Profil berhasil diperbarui');

        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->route('admin.profil')
                            ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
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

        return redirect()->route('admin.profil')
                        ->with('success', 'Password berhasil diperbarui');
    }
}
