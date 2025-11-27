<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;

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
        Paginator::useBootstrapFive();
        // === TAMBAHKAN KODE INI MULAI DARI SINI ===
        
        // Cek jika kita ada di production (Vercel) dan punya datanya
        $googleCredentials = env('GOOGLE_CREDENTIALS_DATA');
        
        if ($googleCredentials) {
            // Tulis isi JSON ke folder /tmp agar bisa dibaca library Google
            // Path ini harus sama dengan yang kamu set di Environment Variable
            file_put_contents('/tmp/credentials.json', $googleCredentials);
        }
        
        // === SAMPAI SINI ===
    }
}
