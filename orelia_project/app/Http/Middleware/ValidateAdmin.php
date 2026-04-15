<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class ValidateAdmin
{
    public function handle(Request $request, Closure $next)
    {
        if (! $request->user() || ! $request->user()->isAdmin()) {
            abort(403, __('general.unauthorized'));
        }

        return $next($request);
    }
}