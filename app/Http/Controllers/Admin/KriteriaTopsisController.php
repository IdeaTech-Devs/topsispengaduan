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

        $kriteria = KriteriaTopsis::create($validated);

        // Tambah nilai kriteria jika ada
        if ($request->has('nilai_item') && is_array($request->nilai_item)) {
            foreach ($request->nilai_item as $i => $item) {
                if ($item && isset($request->nilai_nilai[$i])) {
                    NilaiKriteriaTopsis::create([
                        'id_kriteria' => $kriteria->id_kriteria,
                        'item' => $item,
                        'nilai' => $request->nilai_nilai[$i]
                    ]);
                }
            }
        }

        return redirect()->route('admin.topsis.index')
            ->with('success', 'Kriteria berhasil ditambahkan');
    }

    public function edit($id)
    {
        $kriteria = KriteriaTopsis::with('nilaiKriteria')->findOrFail($id);
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

        // Update nilai kriteria
        NilaiKriteriaTopsis::where('id_kriteria', $kriteria->id_kriteria)->delete();
        if ($request->has('nilai_item') && is_array($request->nilai_item)) {
            foreach ($request->nilai_item as $i => $item) {
                if ($item && isset($request->nilai_nilai[$i])) {
                    NilaiKriteriaTopsis::create([
                        'id_kriteria' => $kriteria->id_kriteria,
                        'item' => $item,
                        'nilai' => $request->nilai_nilai[$i]
                    ]);
                }
            }
        }

        return redirect()->route('admin.topsis.index')
            ->with('success', 'Kriteria berhasil diperbarui');
    }

    public function destroy($id)
    {
        $kriteria = KriteriaTopsis::findOrFail($id);
        $kriteria->nilaiKriteria()->delete();
        $kriteria->delete();
        return redirect()->route('admin.topsis.index')
            ->with('success', 'Kriteria berhasil dihapus');
    }

    public function destroyNilai($id)
    {
        $nilai = NilaiKriteriaTopsis::findOrFail($id);
        $nilai->delete();
        return back()->with('success', 'Nilai kriteria berhasil dihapus');
    }
}
