<?php

namespace App\Providers;

use App\Services\Product\Action;
use Illuminate\Support\ServiceProvider;

class ProductServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind('product.action', fn () => new Action());
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
