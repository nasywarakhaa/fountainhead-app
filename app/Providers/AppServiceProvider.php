<?php

namespace App\Providers;

use App\Models\SiteSetting;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Log;

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
        try {
            // Cek apakah tabel site_settings sudah ada di database
            if (Schema::hasTable('site_settings')) {
                $settings = SiteSetting::pluck('value', 'key')->toArray();
                View::share('settings', $settings);
            }
        } catch (\Exception $e) {
            // Jika database belum ada, Laravel akan mengabaikan error ini
            // sehingga proses 'php artisan migrate' tetap bisa berjalan.
            Log::info("Database belum siap atau belum dibuat: " . $e->getMessage());
        }
    }
}
