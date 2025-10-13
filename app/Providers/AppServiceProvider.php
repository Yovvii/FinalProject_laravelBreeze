<?php

namespace App\Providers;

use App\Models\SpmbStatus;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;

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
        if (Schema::hasTable('spmb_statuses')) { 
        
            // Gunakan '*' untuk memastikan variabel tersedia di SEMUA views, 
            // termasuk layout utama (app.blade.php)
            View::composer('*', function ($view) {
                
                // Ambil status PPDB dari database
                $ppdb_status = SpmbStatus::first(); 

                // Tentukan apakah seleksi telah berakhir (berdasarkan status 'closed')
                $selection_ended = ($ppdb_status && $ppdb_status->status === 'closed'); 
                
                // Variabel $selection_ended sekarang tersedia di SEMUA view
                $view->with('selection_ended', $selection_ended);
            });
        }
    }
}
