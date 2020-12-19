<?php


namespace Kamansoft\Klorchid\Http\Middleware;
use Closure;
use GuzzleHttp\Psr7\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;


class KlorchidKuserEnabled
{
	/**
	 * Handle an incoming request.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \Closure  $next
	 * @return mixed
	 */
	public function handle(Request $request, Closure $next) {
	    \Debugbar::info('KlorchidKuserEnabled Middleware hanlded method was called');
        if (Auth::user()->status == true){
            \Debugbar::info('klorchidKuserEabled Middleware Muser is enabled');
           return  $next($request);
        }else{
           return abort(403);
        }
	}
}