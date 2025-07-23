<?php

namespace App\Http\Controllers;

use App\Models\Fasilitas;
use App\Models\Ruang;
use Illuminate\Http\Request;

class FasilitasController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('role:admin');
    }

    public function index()
    {
        $fasilitas = Fasilitas::with('ruang')->get();
        return view('Admin.fasilitas.index', compact('fasilitas'));
    }

    public function create()
    {
        $ruang = Ruang::all();
        $jenisFasilitas = [
            'Ruang Periksa',
            'Ruang Tindakan',
            'Farmasi',
            'Laboratorium',
            'Gudang Obat',
            'Ruang Tunggu',
            'Toilet',
            'Lainnya'
        ];
        return view('Admin.fasilitas.create', compact('ruang', 'jenisFasilitas'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'ruang_id' => 'required|exists:ruang,id_ruang',
            'nama_fasilitas' => 'required|string|max:100',
            'jenis_fasilitas' => 'required|string|max:50',
            'kode_fasilitas' => 'required|string|max:50|unique:fasilitas,kode_fasilitas',
            'deskripsi' => 'nullable|string',
        ]);
        Fasilitas::create($request->all());
        return redirect()->route('fasilitas.index')->with('success', 'Data fasilitas berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $fasilitas = Fasilitas::findOrFail($id);
        $ruang = Ruang::all();
        $jenisFasilitas = [
            'Ruang Periksa',
            'Ruang Tindakan',
            'Farmasi',
            'Laboratorium',
            'Gudang Obat',
            'Ruang Tunggu',
            'Toilet',
            'Lainnya'
        ];
        return view('Admin.fasilitas.edit', compact('fasilitas', 'ruang', 'jenisFasilitas'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'ruang_id' => 'required|exists:ruang,id_ruang',
            'nama_fasilitas' => 'required|string|max:100',
            'jenis_fasilitas' => 'required|string|max:50',
            'kode_fasilitas' => 'required|string|max:50|unique:fasilitas,kode_fasilitas,' . $id . ',id_fasilitas',
            'deskripsi' => 'nullable|string',
        ]);
        $fasilitas = Fasilitas::findOrFail($id);
        $fasilitas->update($request->all());
        return redirect()->route('fasilitas.index')->with('success', 'Data fasilitas berhasil diupdate.');
    }

    public function destroy($id)
    {
        $fasilitas = Fasilitas::findOrFail($id);
        $fasilitas->delete();
        return redirect()->route('fasilitas.index')->with('success', 'Data fasilitas berhasil dihapus.');
    }
} 