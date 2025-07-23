<?php

namespace App\Http\Controllers;

use App\Models\Kasus;
use App\Models\Satgas;
use App\Models\Pelapor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('role:admin');
    }

    public function dashboard()
    {
        $totalKasus = Kasus::count();
        $kasusBelumSelesai = Kasus::whereIn('status', ['Menunggu', 'Diproses'])->count();
        $kasusSelesai = Kasus::where('status', 'Selesai')->count();
        $kasusDitolak = Kasus::where('status', 'Ditolak')->count();
        $totalSatgas = Satgas::count();
        $totalPelapor = Pelapor::count();

        $kasusTerbaru = Kasus::with('pelapor')
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        return view('admin.dashboard', compact(
            'totalKasus',
            'kasusBelumSelesai',
            'kasusSelesai',
            'kasusDitolak',
            'totalSatgas',
            'totalPelapor',
            'kasusTerbaru'
        ));
    }

    public function kasusBelumSelesai()
    {
        $kasus = Kasus::with('pelapor')
            ->whereIn('status', ['Menunggu', 'Diproses'])
            ->orderBy('created_at', 'desc')
            ->get();

        return view('admin.kasus.belum_selesai', compact('kasus'));
    }

    public function kasusSelesai()
    {
        $kasus = Kasus::with('pelapor')
            ->where('status', 'Selesai')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('admin.kasus.selesai', compact('kasus'));
    }

    public function detailKasus($id)
    {
        $kasus = Kasus::with(['pelapor', 'satgas'])->findOrFail($id);
        $satgas = Satgas::all();
        
        return view('admin.kasus.detail', compact('kasus', 'satgas'));
    }

    public function updateStatus(Request $request, $id)
    {
        $kasus = Kasus::findOrFail($id);
        
        $validated = $request->validate([
            'status' => 'required|in:Menunggu,Diproses,Selesai,Ditolak',
            'catatan_admin' => 'nullable|string'
        ]);

        if ($validated['status'] === 'Diproses' && !$kasus->tanggal_penanganan) {
            $kasus->tanggal_penanganan = Carbon::now();
        }

        if ($validated['status'] === 'Selesai' && !$kasus->tanggal_selesai) {
            $kasus->tanggal_selesai = Carbon::now();
        }

        $kasus->update($validated);

        return redirect()->back()->with('success', 'Status kasus berhasil diperbarui');
    }

    public function assignSatgas(Request $request, $id)
    {
        $kasus = Kasus::findOrFail($id);
        
        $validated = $request->validate([
            'satgas_id' => 'required|exists:satgas,id_satgas'
        ]);

        $kasus->satgas()->attach($validated['satgas_id'], [
            'status_penanganan' => 'Belum ditangani',
            'mulai_penanganan' => Carbon::now()
        ]);

        return redirect()->back()->with('success', 'Satgas berhasil ditugaskan');
    }
}
