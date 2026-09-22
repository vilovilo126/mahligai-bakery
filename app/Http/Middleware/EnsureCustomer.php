<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureCustomer
{
    /**
     * Pastikan pengguna yang mengakses adalah pelanggan (guard web + role customer).
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

        if (! $user || $user->role !== 'customer') {
            abort(403, 'Unauthorized.');
        }

        return $next($request);
    }
}
