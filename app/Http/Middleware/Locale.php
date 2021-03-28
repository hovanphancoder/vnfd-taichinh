<?php

namespace App\Http\Middleware;

use Closure,App,Session,Config;
use Illuminate\Routing\Redirector;
use Illuminate\Http\Request;
use Illuminate\Foundation\Application;
use Illuminate\Contracts\Routing\Middleware;

class Locale
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function __construct(Application $app, Redirector $redirector, Request $request) {
        $this->app = $app;
        $this->redirector = $redirector;
        $this->request = $request;
    }
    public function handle($request, Closure $next)
    {	
		//$language = Session::get('language', Config::get('app.locale'));
        //App::setLocale(App::getLocale());
        if(session('locale')){
       //     dd(session('locale'));
            App::setLocale(session('locale'));
        }
        return $next($request);
    }
}