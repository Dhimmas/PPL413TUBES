<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class IsAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle($request, Closure $next): Response
    {
        if (!auth()->check() || !auth()->user()->is_admin) {
            abort(403, 'Jadi Admin dulu ya!'); // atau redirect ke halaman lain
        }

        return $next($request);
    }
}
