<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;

class Localization
{
    /**
    * Handle an incoming request.
    *
    * @param  \Illuminate\Http\Request  $request
    * @param  \Closure  $next
    * @return mixed
    */
    public function handle(Request $request, Closure $next)
    {
        if (Session::has('locale')) {
            App::setLocale(Session::get('locale'));
        } else {
            $userLangs = preg_split('/,|;/', $request->server('HTTP_ACCEPT_LANGUAGE'));
            foreach (config('app.available_locales') as $lang) {
                if(in_array($lang, $userLangs)) {
                    App::setLocale($lang);
                    Session::push('locale', $lang);
                    break;
                }
            }
        }

        return $next($request);
    }
}
