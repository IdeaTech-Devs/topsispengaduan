<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\Admin;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Auth;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // View composer untuk semua view yang menggunakan layout admin
        View::composer(['admin.*', 'Admin.*'], function ($view) {
            if (Auth::check()) {
                $admin = Admin::where('email', Auth::user()->email)->first();
                $view->with('admin', $admin);
            }
        });
    }
}
