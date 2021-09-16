<?php

namespace App\Http\Middleware;

use Closure;

class SuperAdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (! $request->user()->hasRole('superadmin')) {

            return response(["status" => false, "message" => "Unauthorized User Operation."], 403);
        }
        return $next($request);
    }
}
