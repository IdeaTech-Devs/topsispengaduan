<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckRole
{
    public function handle(Request $request, Closure $next, ...$roles)
    {
        if (!auth()->check()) {
            return redirect('login');
        }

        $user = auth()->user();
        
        if (in_array('admin', $roles) && $user->role === 'admin') {
            return $next($request);
        }
        
        if (in_array('kemahasiswaan', $roles) && $user->id_kemahasiswaan) {
            return $next($request);
        }
        
        if (in_array('satgas', $roles) && $user->id_satgas) {
            return $next($request);
        }

        return redirect('login')->with('error', 'Unauthorized access');
    }
} 