<?php namespace App\Http\Middleware;

use App\LanguageSite;
use Closure;
use Session;
use App;
use Config;

class Locale
{

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $language = session('language', 'en');
        App::setLocale($language);

        return $next($request);
    }

}