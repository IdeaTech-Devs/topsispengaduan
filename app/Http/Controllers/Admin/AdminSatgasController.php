<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Satgas;
use Illuminate\Http\Request;

class AdminSatgasController extends Controller
{
    public function index()
    {
        $satgas = Satgas::orderBy('created_at', 'desc')->get();
        return view('admin.satgas.index', compact('satgas'));
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
            ->with('success', 'Data satgas berhasil ditambahkan');
    }

    public function show($id)
    {
        $satgas = Satgas::findOrFail($id);
        $kasusAktif = $satgas->kasus()
            ->where('status_pengaduan', '!=', 'selesai')
            ->get();

        return view('admin.satgas.show', compact('satgas', 'kasusAktif'));
    }

    public function edit($id)
    {
        $satgas = Satgas::findOrFail($id);
        return view('admin.satgas.edit', compact('satgas'));
    }

    public function update(Request $request, $id)
    {
        $satgas = Satgas::findOrFail($id);
        
        $validated = $request->validate([
            'nama' => 'required|string|max:100',
            'email' => 'required|email|max:100|unique:satgas,email,'.$id.',id_satgas',
            'telepon' => 'required|string|max:15'
        ]);

        $satgas->update($validated);
        return redirect()->route('admin.satgas.index')
            ->with('success', 'Data satgas berhasil diperbarui');
    }

    public function destroy($id)
    {
        $satgas = Satgas::findOrFail($id);
        
        // Cek apakah satgas masih memiliki kasus aktif
        if ($satgas->kasus()->where('status_pengaduan', '!=', 'selesai')->exists()) {
            return redirect()->route('admin.satgas.index')
                ->with('error', 'Tidak dapat menghapus satgas yang masih memiliki kasus aktif');
        }
        
        $satgas->delete();
        return redirect()->route('admin.satgas.index')
            ->with('success', 'Data satgas berhasil dihapus');
    }
} 