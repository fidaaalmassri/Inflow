<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Session;

class LangSwitcher
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

        App::setLocale(Session::has('localLang') ? Session::get('localLang')  : Config::get('app.locale'));
        //        $ar = Session::get('localLang');
        //        App::setLocale($ar);
        
        //        echo '1';
        
        //        print_r(Session::get('localLang'));
        //////
        //        die;
        
                return $next($request);
        
     }
}
