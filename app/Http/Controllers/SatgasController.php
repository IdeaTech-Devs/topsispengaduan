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
            $satgas = auth()->user()->satgas;
            view()->share('satgas', $satgas);
            return $next($request);
        });
    }

    public function dashboard()
    {
        $satgas = auth()->user()->satgas;
        
        // Hitung statistik kasus
        $totalKasusBaru = KasusSatgas::where('satgas_id', $satgas ? $satgas->id_satgas : null)
            ->where('status_penanganan', 'Belum ditangani')
            ->count();
            
        $totalKasusProses = KasusSatgas::where('satgas_id', $satgas ? $satgas->id_satgas : null)
            ->where('status_penanganan', 'Sedang ditangani')
            ->count();
            
        $totalKasusSelesai = KasusSatgas::where('satgas_id', $satgas ? $satgas->id_satgas : null)
            ->where('status_penanganan', 'Selesai')
            ->count();

        return view('satgas.dashboard', compact(
            'satgas',
            'totalKasusBaru',
            'totalKasusProses',
            'totalKasusSelesai'
        ));
    }

    public function kasusBaru()
    {
        $satgas = auth()->user()->satgas;
        $kasusBaru = KasusSatgas::with(['kasus', 'kasus.pelapor'])
            ->where('satgas_id', $satgas ? $satgas->id_satgas : null)
            ->where('status_penanganan', 'Belum ditangani')
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('satgas.kasus_baru', compact('kasusBaru'));
    }

    public function kasusProses()
    {
        $satgas = auth()->user()->satgas;
        $kasusProses = KasusSatgas::with(['kasus', 'kasus.pelapor'])
            ->where('satgas_id', $satgas ? $satgas->id_satgas : null)
            ->where('status_penanganan', 'Sedang ditangani')
            ->orderBy('mulai_penanganan', 'desc')
            ->paginate(10);

        return view('satgas.kasus_proses', compact('kasusProses'));
    }

    public function kasusSelesai()
    {
        $satgas = auth()->user()->satgas;
        $kasusSelesai = KasusSatgas::with(['kasus', 'kasus.pelapor'])
            ->where('satgas_id', $satgas ? $satgas->id_satgas : null)
            ->where('status_penanganan', 'Selesai')
            ->orderBy('selesai_penanganan', 'desc')
            ->paginate(10);

        return view('satgas.kasus_selesai', compact('kasusSelesai'));
    }

    public function detailKasus($id)
    {
        $satgas = auth()->user()->satgas;
        $kasus = Kasus::with(['pelapor', 'satgas', 'kasusSatgas'])
            ->whereHas('kasusSatgas', function($query) use ($satgas) {
                $query->where('satgas_id', $satgas ? $satgas->id_satgas : null);
            })
            ->findOrFail($id);

        return view('satgas.detail_kasus', compact('kasus'));
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
            Log::error('Error updating penanganan status: ' . $e->getMessage());
            return back()->with('error', 'Terjadi kesalahan saat memperbarui status penanganan');
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

            $user = auth()->user();
            $user->email = $request->email;
            $user->save();

            $satgas = $user->satgas;
            if ($satgas) {
                $satgas->nama = $request->nama;
                $satgas->telepon = $request->telepon;
                if ($request->hasFile('foto_profil')) {
                    if ($satgas->foto_profil) {
                        Storage::delete('public/' . $satgas->foto_profil);
                    }
                    $path = $request->file('foto_profil')->store('public/profil/satgas');
                    $satgas->foto_profil = str_replace('public/', '', $path);
                }
                $satgas->save();
            } else {
                DB::rollBack();
                return redirect()->route('satgas.profil')
                    ->with('error', 'Data satgas tidak ditemukan.');
            }

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

        if (!Hash::check($request->current_password, $user->password)) {
            return back()->withErrors([
                'current_password' => 'Password lama tidak sesuai'
            ]);
        }

        $user->password = Hash::make($request->password);
        $user->save();

        return redirect()->route('satgas.profil')
            ->with('success', 'Password berhasil diperbarui');
    }
} 