<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;

class JwtMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $excludedRoutes = [
            '/',
            'api/public/*',
        ];

        // Check if the current request path matches any of the excluded routes
        foreach ($excludedRoutes as $excludedRoute) {
            if ($request->is($excludedRoute)) {
                return $next($request); // Skip JWT authentication for excluded routes
            }
        }

        try {
            // Attempt to parse the token and authenticate the user
            JWTAuth::parseToken()->authenticate();
        } catch (TokenExpiredException $e) {
            try {
                // Refresh the token if expired
                $newToken = JWTAuth::refresh(JWTAuth::getToken());
                $request->headers->set('Authorization', 'Bearer ' . $newToken);
            } catch (JWTException $ex) {
                return response()->json(['error' => 'Token is not valid'], 401);
            }
        } catch (JWTException $e) {
            return response()->json(['error' => 'Token not found'], 401);
        }

        return $next($request);
    }
}
