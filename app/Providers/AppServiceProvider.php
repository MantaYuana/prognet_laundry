<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Models\Outlet;

class AppServiceProvider extends ServiceProvider {
    /**
     * Register any application services.
     */
    public function register(): void {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void {
        View::composer('layouts.navigation', function ($view) {
            $currentOutlet = request()->route('outlet');

            if (is_numeric($currentOutlet)) {
                $currentOutlet = Outlet::find($currentOutlet);
            }

            if (!$currentOutlet && auth()->check() && auth()->user()->owner) {
                $currentOutlet = auth()->user()->owner->outlets()->orderBy('name')->first();
            }

            $view->with('currentOutlet', $currentOutlet);
        });
    }
}
