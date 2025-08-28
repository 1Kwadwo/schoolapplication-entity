<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class BlockExternalRequests
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Block any external HTTP requests
        if ($request->isMethod('get') || $request->isMethod('post')) {
            $host = $request->getHost();
            $allowedHosts = ['localhost', '127.0.0.1', '::1'];
            
            if (!in_array($host, $allowedHosts)) {
                abort(403, 'External requests are blocked in offline mode.');
            }
        }

        return $next($request);
    }
}
