<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Satgas;
use App\Models\Kemahasiswaan;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;

class RegisterController extends Controller
{
    /**
     * Show the registration form.
     */
    public function showRegistrationForm()
    {
        return view('auth.register');
    }

    /**
     * Handle the registration request.
     */
    public function register(Request $request)
    {
        // Validasi input dengan pesan kustom
        $validator = Validator::make($request->all(), [
            'role' => 'required|in:kemahasiswaan,satgas',
            'name' => 'required|string|max:100',
            'email' => 'required|email|unique:users,email',
            'telepon' => 'required|string|max:15',
            'password' => 'required|string|min:8|confirmed',
            'fakultas' => 'required_if:role,kemahasiswaan|string',
        ], [
            'role.required' => 'Silakan pilih peran Anda',
            'role.in' => 'Peran yang dipilih tidak valid',
            'name.required' => 'Nama harus diisi',
            'name.max' => 'Nama tidak boleh lebih dari 100 karakter',
            'email.required' => 'Email harus diisi',
            'email.email' => 'Format email tidak valid',
            'email.unique' => 'Email sudah terdaftar',
            'telepon.required' => 'Nomor telepon harus diisi',
            'telepon.max' => 'Nomor telepon tidak boleh lebih dari 15 karakter',
            'password.required' => 'Password harus diisi',
            'password.min' => 'Password minimal 8 karakter',
            'password.confirmed' => 'Konfirmasi password tidak cocok',
            'fakultas.required_if' => 'Fakultas harus dipilih untuk akun kemahasiswaan',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        try {
            $role = $request->role;

            if ($role === 'kemahasiswaan') {
                // Simpan ke tabel kemahasiswaan
                $kemahasiswaan = Kemahasiswaan::create([
                    'nama' => $request->name,
                    'email' => $request->email,
                    'telepon' => $request->telepon,
                    'fakultas' => $request->fakultas,
                ]);

                // Simpan user dengan role kemahasiswaan
                $user = User::create([
                    'id_kemahasiswaan' => $kemahasiswaan->id_kemahasiswaan,
                    'email' => $request->email,
                    'password' => Hash::make($request->password),
                    'role' => 'kemahasiswaan'
                ]);
            } elseif ($role === 'satgas') {
                // Simpan ke tabel satgas
                $satgas = Satgas::create([
                    'nama' => $request->name,
                    'email' => $request->email,
                    'telepon' => $request->telepon,
                ]);

                // Simpan user dengan role satgas
                $user = User::create([
                    'id_satgas' => $satgas->id_satgas,
                    'email' => $request->email,
                    'password' => Hash::make($request->password),
                    'role' => 'satgas'
                ]);
            }

            return redirect()->route('login')
                ->with('success', 'Registrasi berhasil! Silakan login dengan akun Anda.');

        } catch (\Exception $e) {
            // Log error untuk debugging
            Log::error('Registration error: ' . $e->getMessage());
            
            return redirect()->back()
                ->with('error', 'Terjadi kesalahan saat mendaftar. Silakan coba lagi.')
                ->withInput();
        }
    }
}
