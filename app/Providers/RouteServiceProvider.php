<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Route;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * The path to the route cache file for the application.
     *
     * @var string
     */
    protected $namespace = 'App\Http\Controllers';

    public function boot()
    {
        //
    }

    public function map()
    {
        Route::middleware('web')
            ->namespace($this->namespace)
            ->group(base_path('routes/web.php'));
        
        // Route::middleware('api')
        //     ->namespace($this->namespace)
        //     ->group(base_path('routes/api.php'));
    }
}
