<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        require_once app_path('Http/Helpers/G_helpers.php');
    }
   

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {

       view()->share('st', setting());
       
       
        // $gssd = fix_global_user_data();
           
        // View::share('gsd', $gssd);
    }
}
