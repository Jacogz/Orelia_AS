<?php

namespace App\Filters;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

abstract class ModelFilter
{
    public function apply(Builder $query, Request $request): Builder
    {
        foreach ($this->filters() as $field => $method) {
            if ($request->filled($field)) {
                $this->{$method}($query, $request->input($field));
            }
        }

        return $query;
    }

    abstract protected function filters(): array;
}
