<?php

namespace App\Http\Middleware;

use Closure;
use JWTAuth;

class JWTMiddleware
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
        try {
            $user = JWTAuth::parseToken()->authenticate();
        } catch (\Exception $e) {
            if ($e instanceof \Tymon\JWTAuth\Exceptions\TokenInvalidException) {
                return response()->json(
                    [
                        'status'=>false,
                        'message' => 'Token is Invalid.'
                    ], 422);
            } elseif ($e instanceof \Tymon\JWTAuth\Exceptions\TokenExpiredException) {
                return response()->json(
                    [  
                        'status'=>false,
                        'messsage' => 'Token is Expired.'
                    ], 401);
            } else {
                return response()->json(
                    [ 
                        'status'=>false,
                        'message' => 'Authorization Token not found.'
                    ], 403);
            }
        }

        return $next($request);
    }
}
