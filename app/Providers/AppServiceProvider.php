<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Config;

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
        
        // **PERBAIKAN BAGIAN 1: Memastikan file kredensial ada di /tmp/**
        $credentialsJson = env('GOOGLE_CREDENTIALS_JSON');
        $credentialsPath = env('GOOGLE_SERVICE_ACCOUNT_CREDENTIALS'); // Ini harusnya "/tmp/credentials.json"
        
        // Cek jika konten JSON dan path /tmp tersedia
        if ($credentialsJson && $credentialsPath && str_starts_with($credentialsPath, '/tmp')) {
            try {
                // Tulis isi JSON ke path sementara yang dapat diakses oleh Vercel
                file_put_contents($credentialsPath, $credentialsJson);
                
                // Opsional: Anda dapat menghapus baris di bawah ini jika sudah berhasil
                // Log::info("Google Sheets credentials successfully written to: " . $credentialsPath);
            } catch (\Exception $e) {
                // Log jika gagal menulis file (penting untuk debugging Vercel)
                // Log::error("Failed to write Google credentials file: " . $e->getMessage());
            }
        }
    }
}