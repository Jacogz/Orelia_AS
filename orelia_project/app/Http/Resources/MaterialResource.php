<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class MaterialResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->getId(),
            'name' => $this->getName(),
            'type' => $this->getType(),
            'description' => $this->getDescription(),
            'color' => $this->getColor(),
        ];
    }
}
