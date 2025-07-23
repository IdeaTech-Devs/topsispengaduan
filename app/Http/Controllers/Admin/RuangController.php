<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Ruang;
use Illuminate\Http\Request;

class RuangController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('role:admin');
    }

    public function index()
    {
        $ruang = Ruang::orderBy('nama_ruang')->get();
        return view('admin.ruang.index', compact('ruang'));
    }

    public function create()
    {
        return view('admin.ruang.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_ruang' => 'required|string|max:255',
            'lokasi' => 'required|string|max:255',
            'kode_ruang' => 'required|string|max:50|unique:ruang'
        ]);

        Ruang::create($validated);

        return redirect()->route('admin.ruang.index')
            ->with('success', 'Data ruang berhasil ditambahkan');
    }

    public function show($id)
    {
        $ruang = Ruang::with('fasilitas')->findOrFail($id);
        return view('admin.ruang.show', compact('ruang'));
    }

    public function edit($id)
    {
        $ruang = Ruang::findOrFail($id);
        return view('admin.ruang.edit', compact('ruang'));
    }

    public function update(Request $request, $id)
    {
        $ruang = Ruang::findOrFail($id);
        
        $validated = $request->validate([
            'nama_ruang' => 'required|string|max:255',
            'lokasi' => 'required|string|max:255',
            'kode_ruang' => 'required|string|max:50|unique:ruang,kode_ruang,'.$id.',id_ruang'
        ]);

        $ruang->update($validated);

        return redirect()->route('admin.ruang.index')
            ->with('success', 'Data ruang berhasil diperbarui');
    }

    public function destroy($id)
    {
        $ruang = Ruang::findOrFail($id);
        $ruang->delete();

        return redirect()->route('admin.ruang.index')
            ->with('success', 'Data ruang berhasil dihapus');
    }
} 