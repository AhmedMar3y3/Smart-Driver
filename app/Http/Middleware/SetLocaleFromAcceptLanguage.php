<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;

class SetLocaleFromAcceptLanguage
{
    public function handle(Request $request, Closure $next)
    {
        $acceptLanguage = $request->header('Accept-Language');
        $supportedLocales = config('translatable.locales', ['en']);

        if ($acceptLanguage) {
            $locales = array_map('trim', explode(',', $acceptLanguage));
            foreach ($locales as $locale) {
                $locale = explode(';', $locale)[0];
                $locale = explode('-', $locale)[0];

                if (in_array($locale, $supportedLocales)) {
                    App::setLocale($locale);
                    break;
                }
            }
        }

        return $next($request);
    }
}