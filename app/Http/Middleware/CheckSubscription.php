<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckSubscription
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next)
    {
        $captain = auth('captain')->user();

        if (!$captain || !$captain->is_subscribed) {
            return response()->json(['message' => 'يجب أن تكون مشتركًا للوصول إلى هذه الصفحة'], Response::HTTP_FORBIDDEN);
        }

        return $next($request);
    }
}
