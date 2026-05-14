<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class PieceCollection extends ResourceCollection
{
    public $collects = PieceResource::class;
}
