<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pelapor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AdminPelaporController extends Controller
{
    public function index()
    {
        $pelapor = Pelapor::orderBy('created_at', 'desc')->get();
        return view('admin.pelapor.index', compact('pelapor'));
    }

    public function create()
    {
        return view('admin.pelapor.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_lengkap' => 'required|string|max:100',
            'nama_panggilan' => 'required|string|max:50',
            'unsur' => 'required|in:dosen,mahasiswa,tenaga kependidikan,lainnya',
            'bukti_identitas' => 'required|file|mimes:jpeg,png,jpg,pdf|max:2048',
            'fakultas' => 'required|string|max:50',
            'departemen_prodi' => 'nullable|string|max:50',
            'unit_kerja' => 'nullable|string|max:50',
            'email' => 'required|email|unique:pelapor,email|max:100',
            'no_wa' => 'required|string|max:15',
            'hubungan_korban' => 'nullable|in:diri sendiri,teman,keluarga,lainnya',
            'melapor_sebagai' => 'required|in:korban,saksi,pihak lain'
        ]);

        if ($request->hasFile('bukti_identitas')) {
            $file = $request->file('bukti_identitas');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->storeAs('public/bukti_identitas', $filename);
            $validated['bukti_identitas'] = 'bukti_identitas/' . $filename;
        }

        Pelapor::create($validated);
        return redirect()->route('admin.pelapor.index')
            ->with('success', 'Data pelapor berhasil ditambahkan');
    }

    public function show($id)
    {
        $pelapor = Pelapor::findOrFail($id);
        return view('admin.pelapor.show', compact('pelapor'));
    }

    public function edit($id)
    {
        $pelapor = Pelapor::findOrFail($id);
        return view('admin.pelapor.edit', compact('pelapor'));
    }

    public function update(Request $request, $id)
    {
        $pelapor = Pelapor::findOrFail($id);
        
        $validated = $request->validate([
            'nama_lengkap' => 'required|string|max:100',
            'nama_panggilan' => 'required|string|max:50',
            'unsur' => 'required|in:dosen,mahasiswa,tenaga kependidikan,lainnya',
            'bukti_identitas' => 'nullable|file|mimes:jpeg,png,jpg,pdf|max:2048',
            'fakultas' => 'required|string|max:50',
            'departemen_prodi' => 'nullable|string|max:50',
            'unit_kerja' => 'nullable|string|max:50',
            'email' => 'required|email|max:100|unique:pelapor,email,'.$id.',id_pelapor',
            'no_wa' => 'required|string|max:15',
            'hubungan_korban' => 'nullable|in:diri sendiri,teman,keluarga,lainnya',
            'melapor_sebagai' => 'required|in:korban,saksi,pihak lain'
        ]);

        if ($request->hasFile('bukti_identitas')) {
            // Hapus file lama
            if ($pelapor->bukti_identitas) {
                Storage::delete('public/' . $pelapor->bukti_identitas);
            }
            
            $file = $request->file('bukti_identitas');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->storeAs('public/bukti_identitas', $filename);
            $validated['bukti_identitas'] = 'bukti_identitas/' . $filename;
        }

        $pelapor->update($validated);
        return redirect()->route('admin.pelapor.index')
            ->with('success', 'Data pelapor berhasil diperbarui');
    }

    public function destroy($id)
    {
        $pelapor = Pelapor::findOrFail($id);
        
        // Hapus file bukti identitas
        if ($pelapor->bukti_identitas) {
            Storage::delete('public/' . $pelapor->bukti_identitas);
        }
        
        $pelapor->delete();
        return redirect()->route('admin.pelapor.index')
            ->with('success', 'Data pelapor berhasil dihapus');
    }
} 