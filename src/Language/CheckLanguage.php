<?php

namespace Local\Language;

use Local\Language\LanguageService;
use Closure;

class CheckLanguage
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        LanguageService::get()->setUserLanguage();
        return $next($request);
    }
}
