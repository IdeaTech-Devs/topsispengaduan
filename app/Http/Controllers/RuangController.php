<?php

namespace App\Http\Controllers;

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
        $ruang = Ruang::all();
        return view('Admin.ruang.index', compact('ruang'));
    }

    public function create()
    {
        return view('Admin.ruang.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_ruang' => 'required|string|max:100',
            'lokasi' => 'required|string|max:100',
            'kode_ruang' => 'required|string|max:50|unique:ruang,kode_ruang',
        ]);
        Ruang::create($request->all());
        return redirect()->route('ruang.index')->with('success', 'Data ruang berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $ruang = Ruang::findOrFail($id);
        return view('Admin.ruang.edit', compact('ruang'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_ruang' => 'required|string|max:100',
            'lokasi' => 'required|string|max:100',
            'kode_ruang' => 'required|string|max:50|unique:ruang,kode_ruang,' . $id . ',id_ruang',
        ]);
        $ruang = Ruang::findOrFail($id);
        $ruang->update($request->all());
        return redirect()->route('ruang.index')->with('success', 'Data ruang berhasil diupdate.');
    }

    public function destroy($id)
    {
        $ruang = Ruang::findOrFail($id);
        $ruang->delete();
        return redirect()->route('ruang.index')->with('success', 'Data ruang berhasil dihapus.');
    }
} 