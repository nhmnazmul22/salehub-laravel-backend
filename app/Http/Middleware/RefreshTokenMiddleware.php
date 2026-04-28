<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Facades\JWTAuth;

class RefreshTokenMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param Closure(Request): (Response) $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        try {

            JWTAuth::parseToken()->authenticate();
        } catch (JWTException $e) {
            if ($e instanceof TokenExpiredException) {
                try {
                    $newToken = JWTAuth::refresh();

                    // Add the refresh token to the response header
                    $response = $next($request);
                    $response->headers->set('Authorization', 'Bearer ' . $newToken);
                    return $response;
                } catch (JWTException $e) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Token could not be refreshed'
                    ])->setStatusCode(Response::HTTP_UNAUTHORIZED);
                }
            }

            return response()->json([
                'success' => false,
                'message' => 'Invalid token'
            ])->setStatusCode(Response::HTTP_UNAUTHORIZED);
        }

        return $next($request);
    }
}
