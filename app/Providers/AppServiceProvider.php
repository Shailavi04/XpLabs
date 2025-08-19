<?php

namespace App\Providers;

use App\Models\frontend_elements;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\View;
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
        //

        View::composer('*', function ($view) {
            $sections = frontend_elements::select('section_key', DB::raw('MIN(`order`) as min_order'))
                ->groupBy('section_key')
                ->orderBy('min_order', 'asc')
                ->pluck('section_key');  

            $view->with('sections', $sections);
        });
    }
}
