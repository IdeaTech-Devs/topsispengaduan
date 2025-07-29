<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Satgas;
use Illuminate\Http\Request;

class AdminSatgasController extends Controller
{
    public function index()
    {
        $pimpinan = Satgas::orderBy('created_at', 'desc')->get();
        return view('admin.satgas.index', compact('pimpinan'));
    }

    public function create()
    {
        return view('admin.satgas.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:100',
            'email' => 'required|email|max:100|unique:satgas,email',
            'telepon' => 'required|string|max:15'
        ]);
        
        Satgas::create($validated);
        return redirect()->route('admin.satgas.index')
            ->with('success', 'Data pimpinan berhasil ditambahkan');
    }

    public function show($id)
    {
        $pimpinan = Satgas::findOrFail($id);
        $kasusAktif = $pimpinan->kasus()
            ->where('status', '!=', 'Selesai')
            ->get();

        return view('admin.satgas.show', compact('pimpinan', 'kasusAktif'));
    }

    public function edit($id)
    {
        $pimpinan = Satgas::findOrFail($id);
        return view('admin.satgas.edit', compact('pimpinan'));
    }

    public function update(Request $request, $id)
    {
        $pimpinan = Satgas::findOrFail($id);
        
        $validated = $request->validate([
            'nama' => 'required|string|max:100',
            'email' => 'required|email|max:100|unique:satgas,email,'.$id.',id_satgas',
            'telepon' => 'required|string|max:15'
        ]);

        $pimpinan->update($validated);
        return redirect()->route('admin.satgas.index')
            ->with('success', 'Data pimpinan berhasil diperbarui');
    }

    public function destroy($id)
    {
        $pimpinan = Satgas::findOrFail($id);
        
        // Cek apakah pimpinan masih memiliki kasus aktif
        if ($pimpinan->kasus()->where('status', '!=', 'Selesai')->exists()) {
            return redirect()->route('admin.satgas.index')
                ->with('error', 'Tidak dapat menghapus pimpinan yang masih memiliki kasus aktif');
        }
        
        $pimpinan->delete();
        return redirect()->route('admin.satgas.index')
            ->with('success', 'Data pimpinan berhasil dihapus');
    }
} 