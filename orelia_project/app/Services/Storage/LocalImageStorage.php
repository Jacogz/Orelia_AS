<?php

namespace App\Services\Storage;

use App\Contracts\Storage\ImageStorageInterface;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class LocalImageStorage implements ImageStorageInterface
{
    public function upload(UploadedFile $file, string $pathPrefix): string
    {
        return Storage::disk('public')->putFile($pathPrefix, $file);
    }

    public function getUrl(string $path): string
    {
        return Storage::disk('public')->url($path);
    }

    public function delete(string $path): void
    {
        Storage::disk('public')->delete($path);
    }
}
