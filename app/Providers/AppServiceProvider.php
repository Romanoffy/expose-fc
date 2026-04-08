<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View; // <== ini penting
use App\Models\Teams; // <== pastikan model namanya Team, bukan Teams

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
        // Membuat $teams tersedia di navbar
        View::composer('layouts.components.navbar', function ($view) {
            $teams = Teams::orderBy('name', 'asc')->get(); // ambil semua tim, urut nama
            $view->with('teams', $teams);
        });
    }
}
