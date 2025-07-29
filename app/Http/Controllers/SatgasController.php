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
use Carbon\Carbon;


class SatgasController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('role:satgas');
        
        $this->middleware(function ($request, $next) {
            $pimpinan = auth()->user()->satgas;
            view()->share('pimpinan', $pimpinan);
            return $next($request);
        });
    }

    public function dashboard()
    {
        $pimpinan = auth()->user()->satgas;
        
        // Hitung statistik kasus berdasarkan status di tabel kasus
        $totalKasusProses = Kasus::whereIn('status', ['Menunggu', 'Diproses'])->count();
        $totalKasusSelesai = Kasus::where('status', 'Selesai')->count();

        return view('satgas.dashboard', compact(
            'pimpinan',
            'totalKasusProses',
            'totalKasusSelesai'
        ));
    }

    public function kasusBaru()
    {
        $kasusBaru = Kasus::with(['pelapor'])
            ->where('status', 'Menunggu')
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('satgas.kasus_baru', compact('kasusBaru'));
    }

    public function kasusProses()
    {
        $kasusProses = Kasus::with(['pelapor'])
            ->whereIn('status', ['Menunggu', 'Diproses'])
            ->orderBy('tanggal_penanganan', 'desc')
            ->paginate(10);

        return view('satgas.kasus_proses', compact('kasusProses'));
    }

    public function kasusSelesai()
    {
        $kasusSelesai = Kasus::with(['pelapor'])
            ->where('status', 'Selesai')
            ->orderBy('tanggal_selesai', 'desc')
            ->paginate(10);

        return view('satgas.kasus_selesai', compact('kasusSelesai'));
    }

    public function detailKasus($id)
    {
        $kasus = Kasus::with(['pelapor'])
            ->findOrFail($id);

        return view('satgas.detail_kasus', compact('kasus'));
    }

    public function updateStatusKasus(Request $request, $id)
    {
        $request->validate([
            'status_tindak_lanjut' => 'required|in:selesai',
            'penangan_kasus' => 'required|string',
            'catatan_penanganan' => 'required|string'
        ]);

        try {
            DB::beginTransaction();

            $kasus = Kasus::findOrFail($id);

            // Update status kasus menjadi selesai
            $kasus->status = 'Selesai';
            $kasus->tanggal_selesai = Carbon::now();
            $kasus->catatan_satgas = $request->catatan_penanganan;
            $kasus->save();

            DB::commit();

            return redirect()->route('satgas.kasus_proses')
                ->with('success', 'Kasus berhasil diselesaikan');
                
        } catch (\Exception $e) {
            DB::rollback();
            Log::error('Error updating kasus status: ' . $e->getMessage());
            return redirect()->back()
                ->with('error', 'Terjadi kesalahan saat memperbarui status kasus');
        }
    }

    public function updatePenanganan(Request $request, $id)
    {
        $request->validate([
            'status_penanganan' => 'required|in:Sedang ditangani,Selesai',
            'catatan_penanganan' => 'required|string',
            'foto_penanganan' => 'nullable|image|mimes:jpeg,png,jpg|max:2048'
        ]);

        try {
            DB::beginTransaction();

            $kasusSatgas = KasusSatgas::where('kasus_id', $id)
                ->where('satgas_id', auth()->user()->satgas ? auth()->user()->satgas->id_satgas : null)
                ->firstOrFail();

            $kasus = $kasusSatgas->kasus;

            // Update status penanganan
            $kasusSatgas->status_penanganan = $request->status_penanganan;
            $kasusSatgas->catatan_penanganan = $request->catatan_penanganan;

            if ($request->status_penanganan === 'Sedang ditangani' && !$kasusSatgas->mulai_penanganan) {
                $kasusSatgas->mulai_penanganan = Carbon::now();
                $kasus->status = 'Diproses';
                $kasus->tanggal_penanganan = Carbon::now();
            } elseif ($request->status_penanganan === 'Selesai') {
                $kasusSatgas->selesai_penanganan = Carbon::now();
                $kasus->status = 'Selesai';
                $kasus->tanggal_selesai = Carbon::now();
            }

            // Handle foto penanganan
            if ($request->hasFile('foto_penanganan')) {
                if ($kasus->foto_penanganan) {
                    Storage::delete('public/' . $kasus->foto_penanganan);
                }
                
                $foto_penanganan = $request->file('foto_penanganan')->store('public/foto_penanganan');
                $kasus->foto_penanganan = str_replace('public/', '', $foto_penanganan);
            }

            $kasusSatgas->save();
            $kasus->save();

            DB::commit();

            return redirect()->route('satgas.detail_kasus', $id)
                ->with('success', 'Status penanganan berhasil diperbarui');
            
        } catch (\Exception $e) {
            DB::rollback();
            Log::error('Error updating penanganan: ' . $e->getMessage());
            return redirect()->back()
                ->with('error', 'Terjadi kesalahan saat memperbarui penanganan');
        }
    }

    public function profil()
    {
        $pimpinan = auth()->user()->satgas;
        return view('satgas.profil', compact('pimpinan'));
    }

    public function updateProfil(Request $request)
    {
        $pimpinan = auth()->user()->satgas;
        
        $validated = $request->validate([
            'nama' => 'required|string|max:100',
            'email' => 'required|email|max:100|unique:satgas,email,'.$pimpinan->id_satgas.',id_satgas',
            'telepon' => 'required|string|max:15'
        ]);

        $pimpinan->update($validated);

        return redirect()->route('satgas.profil')
            ->with('success', 'Profil berhasil diperbarui');
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'password_lama' => 'required|string',
            'password_baru' => 'required|string|min:8|confirmed'
        ]);

        $user = auth()->user();

        if (!Hash::check($request->password_lama, $user->password)) {
            return redirect()->back()
                ->withErrors(['password_lama' => 'Password lama tidak sesuai']);
        }

        $user->password = Hash::make($request->password_baru);
        $user->save();

        return redirect()->route('satgas.profil')
            ->with('success', 'Password berhasil diperbarui');
    }

    public function updateFotoProfil(Request $request)
    {
        $request->validate([
            'foto_profil' => 'required|image|mimes:jpeg,png,jpg|max:2048'
        ]);

        $pimpinan = auth()->user()->satgas;

        if ($request->hasFile('foto_profil')) {
            if ($pimpinan->foto_profil) {
                Storage::delete('public/' . $pimpinan->foto_profil);
            }
            
            $foto_profil = $request->file('foto_profil')->store('public/foto_profil');
            $pimpinan->foto_profil = str_replace('public/', '', $foto_profil);
            $pimpinan->save();
        }

        return redirect()->route('satgas.profil')
            ->with('success', 'Foto profil berhasil diperbarui');
    }
} 