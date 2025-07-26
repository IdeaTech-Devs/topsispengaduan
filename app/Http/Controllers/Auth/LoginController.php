<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ], [
            'email.required' => 'Email harus diisi',
            'email.email' => 'Format email tidak valid',
            'password.required' => 'Password harus diisi'
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            
            $user = Auth::user();
            
            // Redirect berdasarkan role
            return match($user->role) {
                'admin' => redirect()->route('admin.dashboard')
                    ->with('success', 'Selamat datang Admin!'),
                    
                'kemahasiswaan' => redirect()->route('kemahasiswaan.dashboard')
                    ->with('success', 'Selamat datang Kemahasiswaan!'),
                    
                'satgas' => redirect()->route('satgas.dashboard')
                    ->with('success', 'Selamat datang Satgas!'),
                    
                default => $this->handleInvalidRole()
            };
        }

        return back()
            ->withErrors([
                'email' => 'Email atau password yang Anda masukkan salah',
            ])
            ->withInput($request->only('email'));
    }

    private function handleInvalidRole()
    {
        Auth::logout();
        return redirect()->route('login')
            ->with('error', 'Akun Anda tidak memiliki akses yang valid.');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        
        return redirect()->route('home')
            ->with('success', 'Anda telah berhasil logout.');
    }
}
