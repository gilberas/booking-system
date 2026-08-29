<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckPermission
{
    public function handle(Request $request, Closure $next, string ...$permissions): Response
    {
        if (! $request->user() || ! $request->user()->hasPermission($permissions)) {
            abort(403, 'Unauthorized action.');
        }

        return $next($request);
    }
}
