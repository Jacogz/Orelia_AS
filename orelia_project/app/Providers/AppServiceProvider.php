<?php

namespace App\Providers;

use App\Contracts\Storage\ImageStorageInterface;
use App\Services\Storage\GcpImageStorage;
use App\Services\Storage\LocalImageStorage;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->singleton(ImageStorageInterface::class, function () {
            $driver = config('filesystems.image_storage_driver', 'local');

            return $driver === 'gcs'
                ? new GcpImageStorage
                : new LocalImageStorage;
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
