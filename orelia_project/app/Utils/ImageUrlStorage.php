<?php

namespace App\Utils;

use App\Interfaces\ImageStorage;
use Illuminate\Http\Request;

class ImageUrlStorage implements ImageStorage
{
    public function store(Request $request): ?string
    {
        $url = $request->input('piece_web_url');

        return blank($url) ? null : $url;
    }
}
