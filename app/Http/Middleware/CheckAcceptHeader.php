<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckAcceptHeader
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle($request, Closure $next)
    {
        if (!$request->wantsJson()) {
            return response()->json([
                'errors' => [
                    [
                        'code' => 'media_type_not_acceptable',
                        'message' => 'The Accept header should send a media type of application/json'
                    ]
                ]
            ], 406); // 406 Not Acceptable
        }

        return $next($request);
    }
}
