<?php

namespace App\Contracts\Storage;

use Illuminate\Http\UploadedFile;

interface ImageStorageInterface
{
    public function upload(UploadedFile $file, string $pathPrefix): string;

    public function getUrl(string $path): string;

    public function delete(string $path): void;
}
