<?php

namespace App\Utils;

use App\Interfaces\ImageStorage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ImageGCPStorage implements ImageStorage
{
    public function store(Request $request): ?string
    {
        if ($request->hasFile('piece_image')) {
            $file = $request->file('piece_image');
            Storage::disk('gcs')->put(
                'pieces/'.$file->hashName(),
                file_get_contents($file->getRealPath())
            );

            return 'pieces/'.$file->hashName();
        }

        $url = $request->input('piece_web_url');

        return blank($url) ? null : $url;
    }
}
