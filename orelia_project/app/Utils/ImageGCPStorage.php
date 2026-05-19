<?php

namespace App\Utils;

use App\Interfaces\ImageStorage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ImageGCPStorage implements ImageStorage
{
    public function store(Request $request): void
    {
        if ($request->hasFile('piece_image')) {
            Storage::disk('gcs')->put(
                'pieces/'.$request->file('piece_image')->hashName(),
                file_get_contents($request->file('piece_image')->getRealPath())
            );
        }
    }
}
