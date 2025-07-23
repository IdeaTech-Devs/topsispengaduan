<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Models\Admin;
use Illuminate\Support\Facades\Auth;

class AdminServiceProvider extends ServiceProvider
{
    public function register()
    {
        //
    }

    public function boot()
    {
        // View composer untuk semua view admin
        View::composer('admin.*', function($view) {
            if (Auth::check()) {
                $admin = Admin::firstOrCreate(
                    ['email' => Auth::user()->email],
                    [
                        'nama' => Auth::user()->name,
                        'email' => Auth::user()->email
                    ]
                );

                $view->with([
                    'nama_admin' => $admin->nama ?? Auth::user()->name,
                    'foto_admin' => $admin->foto_profil 
                        ? asset('storage/'.$admin->foto_profil) 
                        : asset('assets/img/undraw_profile.svg')
                ]);
            }
        });
    }
} 