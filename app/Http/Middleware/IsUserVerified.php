<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;

class IsUserVerified
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (Gate::allows('is_user') && !Gate::allows('is_user_verified')) { // Apply the middleware only for normal users. Admins are bypassed.
            throw new AccessDeniedHttpException('Access denied: user\'s account not verified.');
        }
        return $next($request);
    }
}
