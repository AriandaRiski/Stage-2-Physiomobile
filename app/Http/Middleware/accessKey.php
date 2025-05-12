<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class accessKey
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $accessKey = $request->header('accessKey');
        $validKey = config('app.api_access_key');
        if (!$accessKey || $accessKey !== $validKey) {
            return response()->json(['message' => 'Unauthorized - invalid accessKey'], 401);
        }
        return $next($request);
    }
}
