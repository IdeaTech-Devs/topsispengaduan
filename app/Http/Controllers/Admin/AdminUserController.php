<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Satgas;
use App\Models\Kemahasiswaan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AdminUserController extends Controller
{
    public function index()
    {
        $users = User::with(['kemahasiswaan', 'satgas'])
            ->orderBy('created_at', 'desc')
            ->get();
        return view('admin.users.index', compact('users'));
    }

    public function create()
    {
        $satgas = Satgas::all();
        $kemahasiswaan = Kemahasiswaan::all();
        return view('admin.users.create', compact('satgas', 'kemahasiswaan'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'email' => 'required|string|email|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'role' => 'required|in:admin,kemahasiswaan,satgas',
            'id_kemahasiswaan' => 'nullable|required_if:role,kemahasiswaan|exists:kemahasiswaan,id_kemahasiswaan',
            'id_satgas' => 'nullable|required_if:role,satgas|exists:satgas,id_satgas'
        ]);

        $validated['password'] = Hash::make($validated['password']);

        // Pastikan id_kemahasiswaan dan id_satgas sesuai dengan role
        if ($validated['role'] !== 'kemahasiswaan') {
            $validated['id_kemahasiswaan'] = null;
        }
        if ($validated['role'] !== 'satgas') {
            $validated['id_satgas'] = null;
        }
        
        User::create($validated);
        return redirect()->route('admin.users.index')
            ->with('success', 'User berhasil ditambahkan');
    }

    public function edit($id)
    {
        $user = User::findOrFail($id);
        $satgas = Satgas::all();
        $kemahasiswaan = Kemahasiswaan::all();
        return view('admin.users.edit', compact('user', 'satgas', 'kemahasiswaan'));
    }

    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);
        
        $validated = $request->validate([
            'email' => 'required|string|email|unique:users,email,'.$id,
            'password' => 'nullable|string|min:8|confirmed',
            'role' => 'required|in:admin,kemahasiswaan,satgas',
            'id_kemahasiswaan' => 'nullable|required_if:role,kemahasiswaan|exists:kemahasiswaan,id_kemahasiswaan',
            'id_satgas' => 'nullable|required_if:role,satgas|exists:satgas,id_satgas'
        ]);

        // Update password hanya jika diisi
        if ($request->filled('password')) {
            $validated['password'] = Hash::make($validated['password']);
        } else {
            unset($validated['password']);
        }

        // Pastikan id_kemahasiswaan dan id_satgas sesuai dengan role
        if ($validated['role'] !== 'kemahasiswaan') {
            $validated['id_kemahasiswaan'] = null;
        }
        if ($validated['role'] !== 'satgas') {
            $validated['id_satgas'] = null;
        }

        $user->update($validated);
        return redirect()->route('admin.users.index')
            ->with('success', 'Data user berhasil diperbarui');
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);
        
        // Cek jika user yang akan dihapus bukan user yang sedang login
        if ($user->id === auth()->id()) {
            return redirect()->route('admin.users.index')
                ->with('error', 'Tidak dapat menghapus akun yang sedang digunakan');
        }
        
        $user->delete();
        return redirect()->route('admin.users.index')
            ->with('success', 'User berhasil dihapus');
    }
} 