<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Services\FirebaseStorageService;
use Google\Cloud\Storage\StorageClient;

class FirebaseServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->singleton(FirebaseStorageService::class, function ($app) {
            return new FirebaseStorageService();
        });
    }

    public function boot()
    {
        //
    }
}