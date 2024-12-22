<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\KriteriaTopsis;
use App\Models\NilaiKriteriaTopsis;

class KriteriaTopsisController extends Controller
{
    public function index()
    {
        $kriteria = KriteriaTopsis::with('nilaiKriteria')->get();
        return view('admin.topsis.index', compact('kriteria'));
    }

    public function create()
    {
        return view('admin.topsis.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_kriteria' => 'required|string|max:255',
            'bobot' => 'required|numeric|between:0,1',
            'jenis' => 'required|in:benefit,cost',
        ]);

        KriteriaTopsis::create($validated);
        return redirect()->route('admin.topsis.index')
            ->with('success', 'Kriteria berhasil ditambahkan');
    }

    public function edit($id)
    {
        $kriteria = KriteriaTopsis::findOrFail($id);
        return view('admin.topsis.edit', compact('kriteria'));
    }

    public function update(Request $request, $id)
    {
        $kriteria = KriteriaTopsis::findOrFail($id);
        
        $validated = $request->validate([
            'nama_kriteria' => 'required|string|max:255',
            'bobot' => 'required|numeric|between:0,1',
            'jenis' => 'required|in:benefit,cost',
        ]);

        $kriteria->update($validated);
        return redirect()->route('admin.topsis.index')
            ->with('success', 'Kriteria berhasil diperbarui');
    }

    public function destroy($id)
    {
        $kriteria = KriteriaTopsis::findOrFail($id);
        $kriteria->delete();
        
        return redirect()->route('admin.topsis.index')
            ->with('success', 'Kriteria berhasil dihapus');
    }
}
