<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class Client
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $client = Auth::guard('client')->user();
        
        if (!$client) {
            logger('client middleware: No authenticated client.');
            return response()->json(['message' => 'Unauthorizes: clients only can access this route'], 403);
        }
    
        logger('client middleware: client authenticated.', ['client' => $client]);
        return $next($request);
    }
}
