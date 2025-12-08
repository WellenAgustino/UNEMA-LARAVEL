<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator; // 1. Impor Paginator

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
        // Mengatur tema default untuk paginator Laravel standar
        // Mengatur tema paginasi default untuk seluruh aplikasi ke view kustom.
        Paginator::defaultView('vendor.pagination.bootstrap-5-dark');
    }
}
