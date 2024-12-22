<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AdminManagementController extends Controller
{
    public function index()
    {
        $admins = Admin::all();
        return view('admin.management.index', compact('admins'));
    }

    public function create()
    {
        return view('admin.management.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:100',
            'email' => 'required|email|unique:admin,email|max:100',
            'telepon' => 'required|string|max:15',
            'foto_profil' => 'nullable|image|mimes:jpeg,png,jpg|max:2048'
        ]);

        if ($request->hasFile('foto_profil')) {
            $file = $request->file('foto_profil');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->storeAs('public/admin', $filename);
            $validated['foto_profil'] = 'admin/' . $filename;
        }

        Admin::create($validated);
        return redirect()->route('admin.management.index')
            ->with('success', 'Data admin berhasil ditambahkan');
    }

    public function edit($id)
    {
        $admin = Admin::findOrFail($id);
        return view('admin.management.edit', compact('admin'));
    }

    public function update(Request $request, $id)
    {
        $admin = Admin::findOrFail($id);
        
        $validated = $request->validate([
            'nama' => 'required|string|max:100',
            'email' => 'required|email|max:100|unique:admin,email,'.$id.',id_admin',
            'telepon' => 'required|string|max:15',
            'foto_profil' => 'nullable|image|mimes:jpeg,png,jpg|max:2048'
        ]);

        if ($request->hasFile('foto_profil')) {
            // Hapus foto lama jika ada
            if ($admin->foto_profil) {
                Storage::delete('public/' . $admin->foto_profil);
            }
            
            $file = $request->file('foto_profil');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->storeAs('public/admin', $filename);
            $validated['foto_profil'] = 'admin/' . $filename;
        }

        $admin->update($validated);
        return redirect()->route('admin.management.index')
            ->with('success', 'Data admin berhasil diperbarui');
    }

    public function destroy($id)
    {
        $admin = Admin::findOrFail($id);
        
        // Hapus foto profil jika ada
        if ($admin->foto_profil) {
            Storage::delete('public/' . $admin->foto_profil);
        }
        
        $admin->delete();
        return redirect()->route('admin.management.index')
            ->with('success', 'Data admin berhasil dihapus');
    }
} 