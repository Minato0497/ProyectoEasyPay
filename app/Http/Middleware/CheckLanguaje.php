<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;

class CheckLanguaje
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
        if (Session::has('language')) {
            if (App::getLocale() != Session::get('language')) {

                //Windows necesita 'es', linux necesita 'es_ES'
                $locale = "";
                if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') {
                    $locale = Session::get('language');
                } else {
                    $locale = Session::get('language') . '_' . strtoupper(Session::get('language'));
                }
                App::setLocale($locale);
                setlocale(LC_TIME, $locale);

                //dd(Session::get ('language'));
            }
        } else {
            Session::put('language', 'en');

            //Windows necesita 'es', linux necesita 'es_ES'
            $locale = "";
            if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') {
                $locale = 'en';
            } else {
                $locale = 'en_EN';
            }
            App::setLocale($locale);
            setlocale(LC_TIME, $locale);
        }

        return $next($request);
    }
}
