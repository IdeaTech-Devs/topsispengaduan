<?php

namespace App\Http\Controllers;

use App\Models\Satgas;
use App\Models\Kasus;
use App\Models\KasusSatgas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class SatgasController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('role:satgas');
        
        // Share data satgas ke semua view
        $this->middleware(function ($request, $next) {
            $satgas = Satgas::where('id_satgas', Auth::user()->id_satgas)->first();
            view()->share('satgas', $satgas);
            return $next($request);
        });
    }

    public function dashboard()
    {
        $satgas = Satgas::where('id_satgas', Auth::user()->id_satgas)->first();
        
        // Hitung statistik kasus
        $totalKasusBaru = KasusSatgas::where('id_satgas', $satgas->id_satgas)
            ->whereHas('kasus', function($query) {
                $query->where('status_pengaduan', 'dikonfirmasi');
            })
            ->count();
            
        $totalKasusProses = KasusSatgas::where('id_satgas', $satgas->id_satgas)
            ->whereHas('kasus', function($query) {
                $query->where('status_pengaduan', 'proses satgas');
            })
            ->count();
            
        $totalKasusSelesai = KasusSatgas::where('id_satgas', $satgas->id_satgas)
            ->whereHas('kasus', function($query) {
                $query->where('status_pengaduan', 'selesai');
            })
            ->count();

        return view('satgas.dashboard', compact(
            'satgas',
            'totalKasusBaru',
            'totalKasusProses',
            'totalKasusSelesai'
        ));
    }

    public function kasusProses()
    {
        $satgas = Satgas::where('id_satgas', Auth::user()->id_satgas)->first();
        
        $kasusProses = KasusSatgas::with(['kasus', 'kasus.pelapor'])
            ->where('id_satgas', $satgas->id_satgas)
            ->whereHas('kasus', function($query) {
                $query->where('status_pengaduan', 'proses satgas');
            })
            ->orderBy('tanggal_tindak_lanjut', 'desc')
            ->paginate(10);

        return view('satgas.kasus_proses', compact('satgas', 'kasusProses'));
    }

    public function kasusSelesai()
    {
        $satgas = Satgas::where('id_satgas', Auth::user()->id_satgas)->first();
        
        $kasusSelesai = KasusSatgas::with(['kasus', 'kasus.pelapor'])
            ->where('id_satgas', $satgas->id_satgas)
            ->whereHas('kasus', function($query) {
                $query->where('status_pengaduan', 'selesai');
            })
            ->orderBy('tanggal_tindak_selesai', 'desc')
            ->paginate(10);

        return view('satgas.kasus_selesai', compact('satgas', 'kasusSelesai'));
    }

    public function detailKasus($id_kasus)
    {
        $satgas = Satgas::where('id_satgas', Auth::user()->id_satgas)->first();
        
        // Menggunakan model Kasus seperti di AdminController
        $kasus = Kasus::with(['pelapor', 'kemahasiswaan', 'satgas', 'kasus_satgas.satgas'])
            ->whereHas('kasus_satgas', function($query) use ($satgas) {
                $query->where('id_satgas', $satgas->id_satgas);
            })
            ->findOrFail($id_kasus);

        return view('satgas.detail_kasus', compact('satgas', 'kasus'));
    }

    public function updateStatusKasus(Request $request, $id_kasus)
    {
        $request->validate([
            'status_tindak_lanjut' => 'required|in:selesai',
            'catatan_penanganan' => 'required|string',
            'penangan_kasus' => 'required'
        ]);

        $satgas = Satgas::where('id_satgas', Auth::user()->id_satgas)->first();
        
        try {
            DB::beginTransaction();

            $kasus = Kasus::findOrFail($id_kasus);
            
            // Update kasus langsung
            $kasus->update([
                'status_pengaduan' => 'selesai',
                'catatan_penanganan' => $request->catatan_penanganan,
                'penangan_kasus' => $request->penangan_kasus
            ]);

            // Update status di kasus_satgas
            $kasus->satgas()->updateExistingPivot($satgas->id_satgas, [
                'status_tindak_lanjut' => 'selesai',
                'tanggal_tindak_selesai' => now()
            ]);

            DB::commit();

            return redirect()->route('satgas.kasus_proses')
                ->with('success', 'Status kasus berhasil diperbarui menjadi selesai');
            
        } catch (\Exception $e) {
            DB::rollback();
            Log::error('Error updating kasus status: ' . $e->getMessage());
            Log::error('Stack trace: ' . $e->getTraceAsString());
            return back()->with('error', 'Terjadi kesalahan saat memperbarui status kasus: ' . $e->getMessage());
        }
    }

    public function profil()
    {
        return view('satgas.profil');
    }

    public function updateProfil(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:100',
            'email' => 'required|email|unique:users,email,' . auth()->id(),
            'telepon' => 'required|string|max:15',
            'foto_profil' => 'nullable|image|mimes:jpeg,png,jpg|max:2048'
        ]);

        try {
            DB::beginTransaction();

            // Update data di tabel users
            $user = auth()->user();
            $user->email = $request->email;
            $user->save();

            // Update data di tabel satgas
            $satgas = Satgas::find($user->id_satgas);
            $satgas->nama = $request->nama;
            $satgas->telepon = $request->telepon;

            // Handle foto profil
            if ($request->hasFile('foto_profil')) {
                // Hapus foto lama jika ada
                if ($satgas->foto_profil) {
                    Storage::delete('public/' . $satgas->foto_profil);
                }
                
                // Simpan foto baru
                $path = $request->file('foto_profil')->store('profil/satgas', 'public');
                $satgas->foto_profil = $path;
            }

            $satgas->save();

            DB::commit();
            return redirect()->route('satgas.profil')
                            ->with('success', 'Profil berhasil diperbarui');

        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->route('satgas.profil')
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

        return redirect()->route('satgas.profil')
                        ->with('success', 'Password berhasil diperbarui');
    }
} 