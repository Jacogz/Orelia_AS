<?php

namespace App\Filters;

use Illuminate\Database\Eloquent\Builder;

class MaterialFilter extends ModelFilter
{
    protected function filters(): array
    {
        return [
            'name' => 'name',
            'type' => 'type',
            'color' => 'color',
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

    protected function color(Builder $query, $value): void
    {
        $query->where('color', 'like', '%'.$value.'%');
    }
}
