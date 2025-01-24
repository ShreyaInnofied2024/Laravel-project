<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
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
    public function boot()
    {
    View::composer('*', function ($view) {
        if (Auth::check()) {
            $userId = Auth::id();
            $cartCount = \App\Models\Cart::where('user_id', $userId)->sum('quantity');
            $view->with('cartCount', $cartCount);
        } else {
            $view->with('cartCount', 0);
        }
    });
}

}
