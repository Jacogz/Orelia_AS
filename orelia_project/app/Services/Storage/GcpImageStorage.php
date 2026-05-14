<?php

namespace App\Services\Storage;

use App\Contracts\Storage\ImageStorageInterface;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class GcpImageStorage implements ImageStorageInterface
{
    public function upload(UploadedFile $file, string $pathPrefix): string
    {
        return Storage::disk('gcs')->putFile($pathPrefix, $file);
    }

    public function getUrl(string $path): string
    {
        return Storage::disk('gcs')->url($path);
    }

    public function delete(string $path): void
    {
        Storage::disk('gcs')->delete($path);
    }
}
