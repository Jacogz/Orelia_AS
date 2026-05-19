<?php

namespace App\Providers;

use App\Interfaces\ImageStorage;
use App\Utils\ImageGCPStorage;
use App\Utils\ImageLocalStorage;
use App\Utils\ImageUrlStorage;
use Illuminate\Support\ServiceProvider;

class ImageServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(ImageStorage::class, function () {
            $driver = config('services.image_storage.driver', 'local');

            return match ($driver) {
                'gcp' => new ImageGCPStorage,
                'url' => new ImageUrlStorage,
                default => new ImageLocalStorage,
            };
        });
    }
}
