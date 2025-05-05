<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class Captain
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $captain = Auth::guard('captain')->user();
        
        if (!$captain) {
            return response()->json(['message' => 'غير مصرح: يمكن للمدربين فقط الوصول إلى هذا المسار'], 403);
        }
    
        return $next($request);
    }
}
