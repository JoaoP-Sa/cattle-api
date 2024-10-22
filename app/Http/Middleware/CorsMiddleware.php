<?php

namespace App\Http\Middleware;

use Closure;

class CorsMiddleware
{
    public function handle($request, Closure $next)
    {

        $response = $next($request);

        // Adicione os cabeçalhos CORS
        $response->headers->set('Access-Control-Allow-Origin', '*'); // Ou especifique as origens
        $response->headers->set('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, OPTIONS');
        $response->headers->set('Access-Control-Allow-Headers', 'Content-Type, Authorization');

        return $response;
    }
}
