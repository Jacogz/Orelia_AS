<?php

namespace App\Filters;

use Illuminate\Database\Eloquent\Builder;

class CollectionFilter extends ModelFilter
{
    protected function filters(): array
    {
        return [
            'name' => 'name',
            'description' => 'description',
        ];
    }

    protected function name(Builder $query, $value): void
    {
        $query->where('name', 'like', '%'.$value.'%');
    }

    protected function description(Builder $query, $value): void
    {
        $query->where('description', 'like', '%'.$value.'%');
    }
}
