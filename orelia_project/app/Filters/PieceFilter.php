<?php

namespace App\Filters;

use Illuminate\Database\Eloquent\Builder;

class PieceFilter extends ModelFilter
{
    protected function filters(): array
    {
        return [
            'name' => 'name',
            'type' => 'type',
            'min_price' => 'minPrice',
            'max_price' => 'maxPrice',
            'collection_id' => 'collectionId',
            'stock' => 'stock',
        ];
    }

    protected function name(Builder $query, $value): void
    {
        $query->where('name', 'like', '%'.$value.'%');
    }

    protected function type(Builder $query, $value): void
    {
        $query->where('type', $value);
    }

    protected function minPrice(Builder $query, $value): void
    {
        $query->where('price', '>=', $value);
    }

    protected function maxPrice(Builder $query, $value): void
    {
        $query->where('price', '<=', $value);
    }

    protected function collectionId(Builder $query, $value): void
    {
        $query->where('collection_id', $value);
    }

    protected function stock(Builder $query, $value): void
    {
        if ($value === 'available') {
            $query->where('stock', '>', 0);
        }
    }
}
