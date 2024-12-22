<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Kemahasiswaan;
use Illuminate\Http\Request;

class AdminKemahasiswaanController extends Controller
{
    public function index()
    {
        $kemahasiswaan = Kemahasiswaan::orderBy('created_at', 'desc')->get();
        return view('admin.kemahasiswaan.index', compact('kemahasiswaan'));
    }

    public function create()
    {
        return view('admin.kemahasiswaan.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:100',
            'email' => 'required|email|max:100|unique:kemahasiswaan,email',
            'telepon' => 'required|string|max:15',
            'fakultas' => 'required|in:Teknik,Hukum,Pertanian,Ilmu Sosial dan Ilmu Politik,Keguruan dan Ilmu Pendidikan,Ekonomi dan Bisnis,Kedokteran dan Ilmu Kesehatan,Matematika dan Ilmu Pengetahuan Alam'
        ]);
        
        Kemahasiswaan::create($validated);
        return redirect()->route('admin.kemahasiswaan.index')
            ->with('success', 'Data kemahasiswaan berhasil ditambahkan');
    }

    public function show($id)
    {
        $kemahasiswaan = Kemahasiswaan::findOrFail($id);
        return view('admin.kemahasiswaan.show', compact('kemahasiswaan'));
    }

    public function edit($id)
    {
        $kemahasiswaan = Kemahasiswaan::findOrFail($id);
        return view('admin.kemahasiswaan.edit', compact('kemahasiswaan'));
    }

    public function update(Request $request, $id)
    {
        $kemahasiswaan = Kemahasiswaan::findOrFail($id);
        
        $validated = $request->validate([
            'nama' => 'required|string|max:100',
            'email' => 'required|email|max:100|unique:kemahasiswaan,email,'.$id.',id_kemahasiswaan',
            'telepon' => 'required|string|max:15',
            'fakultas' => 'required|in:Teknik,Hukum,Pertanian,Ilmu Sosial dan Ilmu Politik,Keguruan dan Ilmu Pendidikan,Ekonomi dan Bisnis,Kedokteran dan Ilmu Kesehatan,Matematika dan Ilmu Pengetahuan Alam'
        ]);

        $kemahasiswaan->update($validated);
        return redirect()->route('admin.kemahasiswaan.index')
            ->with('success', 'Data kemahasiswaan berhasil diperbarui');
    }

    public function destroy($id)
    {
        $kemahasiswaan = Kemahasiswaan::findOrFail($id);
        $kemahasiswaan->delete();
        return redirect()->route('admin.kemahasiswaan.index')
            ->with('success', 'Data kemahasiswaan berhasil dihapus');
    }
} 