<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        if (Auth::check() && Auth::user()->role === 'admin') {
            return $next($request);
        }
        
        // Redirect sesuai role
        if (Auth::check()) {
            switch(Auth::user()->role) {
                case 'kemahasiswaan':
                    return redirect()->route('kemahasiswaan.dashboard');
                case 'satgas':
                    return redirect()->route('satgas.dashboard');
                default:
                    return redirect()->route('login')
                        ->with('error', 'Anda tidak memiliki akses yang valid.');
            }
        }

        return redirect()->route('login')
            ->with('error', 'Anda harus login terlebih dahulu.');
    }
} 