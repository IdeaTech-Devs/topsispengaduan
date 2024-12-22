<?php

namespace App\Http\Controllers;

use App\Models\Kasus;
use App\Models\Pelapor;
use Illuminate\Http\Request;

class KasusController extends Controller
{
    // Menampilkan form untuk membuat kasus baru
    public function create()
    {
        $pelapor = Pelapor::all(); // Mengambil semua pelapor
        return view('kasus.create', compact('pelapor')); // Ganti dengan nama view yang sesuai
    }

    // Menyimpan data kasus baru
    public function store(Request $request)
    {
        $request->validate([
            'id_kemahasiswaan' => 'nullable|integer', // Jika ada tabel kemahasiswaan
            'id_pelapor' => 'required|exists:pelapor,id_pelapor',
            'jenis_masalah' => 'required|in:bullying,kekerasan seksual,pelecehan verbal,diskriminasi,cyberbullying,lainnya',
            'urgensi' => 'required|in:segera,dalam beberapa hari,tidak mendesak',
            'dampak' => 'required|in:sangat besar,sedang,kecil',
        ]);

        Kasus::create($request->all());

        return redirect()->route('kasus.index')->with('success', 'Kasus berhasil ditambahkan.');
    }

    // Menampilkan daftar kasus
    public function index()
    {
        $kasus = Kasus::with('pelapor')->get(); // Mengambil semua kasus dengan relasi pelapor
        return view('kasus.index', compact('kasus')); // Ganti dengan nama view yang sesuai
    }

    // Menampilkan form untuk mengedit kasus
    public function edit($id)
    {
        $kasus = Kasus::findOrFail($id);
        $pelapor = Pelapor::all(); // Mengambil semua pelapor
        return view('kasus.edit', compact('kasus', 'pelapor')); // Ganti dengan nama view yang sesuai
    }

    // Memperbarui data kasus
    public function update(Request $request, $id)
    {
        $request->validate([
            'id_kemahasiswaan' => 'nullable|integer', // Jika ada tabel kemahasiswaan
            'id_pelapor' => 'required|exists:pelapor,id_pelapor',
            'jenis_masalah' => 'required|in:bullying,kekerasan seksual,pelecehan verbal,diskriminasi,cyberbullying,lainnya',
            'urgensi' => 'required|in:segera,dalam beberapa hari,tidak mendesak',
            'dampak' => 'required|in:sangat besar,sedang,kecil',
        ]);

        $kasus = Kasus::findOrFail($id);
        $kasus->update($request->all());

        return redirect()->route('kasus.index')->with('success', 'Kasus berhasil diperbarui.');
    }

    // Menghapus kasus
    public function destroy($id)
    {
        $kasus = Kasus::findOrFail($id);
        $kasus->delete();

        return redirect()->route('kasus.index')->with('success', 'Kasus berhasil dihapus.');
    }
}
