<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PieceResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->getId(),
            'name' => $this->getName(),
            'description' => $this->getDescription(),
            'price' => $this->getPrice(),
            'type' => $this->getType(),
            'image_url' => $this->getImageUrl(),
            'stock' => $this->getStock(),
            'size' => $this->getSize(),
            'weight' => $this->getWeight(),
            'view_url' => route('pieces.show', ['id' => $this->getId()]),
            'collection' => new CollectionResource($this->getCollection()),
            'materials' => MaterialResource::collection($this->whenLoaded('materials')),
        ];
    }
}
