<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Fasilitas;
use App\Models\Ruang;
use Illuminate\Http\Request;

class FasilitasController extends Controller
{
    protected $jenisFasilitas = [
        'Meja',
        'Kursi',
        'Papan Tulis',
        'Proyektor',
        'AC',
        'Lampu',
        'Stop Kontak',
        'Wifi',
        'CCTV',
        'Lainnya'
    ];

    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('role:admin');
    }

    public function index()
    {
        $fasilitas = Fasilitas::with('ruang')->orderBy('nama_fasilitas')->get();
        return view('admin.fasilitas.index', compact('fasilitas'));
    }

    public function create()
    {
        $ruang = Ruang::orderBy('nama_ruang')->get();
        return view('admin.fasilitas.create', [
            'ruang' => $ruang,
            'jenisFasilitas' => $this->jenisFasilitas
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'ruang_id' => 'required|exists:ruang,id_ruang',
            'nama_fasilitas' => 'required|string|max:255',
            'jenis_fasilitas' => 'required|string|max:50',
            'kode_fasilitas' => 'required|string|max:50|unique:fasilitas',
            'deskripsi' => 'nullable|string'
        ]);

        Fasilitas::create($validated);

        return redirect()->route('admin.fasilitas.index')
            ->with('success', 'Data fasilitas berhasil ditambahkan');
    }

    public function show($id)
    {
        $fasilitas = Fasilitas::with('ruang')->findOrFail($id);
        return view('admin.fasilitas.show', compact('fasilitas'));
    }

    public function edit($id)
    {
        $fasilitas = Fasilitas::findOrFail($id);
        $ruang = Ruang::orderBy('nama_ruang')->get();
        return view('admin.fasilitas.edit', [
            'fasilitas' => $fasilitas,
            'ruang' => $ruang,
            'jenisFasilitas' => $this->jenisFasilitas
        ]);
    }

    public function update(Request $request, $id)
    {
        $fasilitas = Fasilitas::findOrFail($id);
        
        $validated = $request->validate([
            'ruang_id' => 'required|exists:ruang,id_ruang',
            'nama_fasilitas' => 'required|string|max:255',
            'jenis_fasilitas' => 'required|string|max:50',
            'kode_fasilitas' => 'required|string|max:50|unique:fasilitas,kode_fasilitas,'.$id.',id_fasilitas',
            'deskripsi' => 'nullable|string'
        ]);

        $fasilitas->update($validated);

        return redirect()->route('admin.fasilitas.index')
            ->with('success', 'Data fasilitas berhasil diperbarui');
    }

    public function destroy($id)
    {
        $fasilitas = Fasilitas::findOrFail($id);
        $fasilitas->delete();

        return redirect()->route('admin.fasilitas.index')
            ->with('success', 'Data fasilitas berhasil dihapus');
    }
} 