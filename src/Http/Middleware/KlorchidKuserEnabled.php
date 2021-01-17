<?php


namespace Kamansoft\Klorchid\Http\Middleware;
use Closure;
use GuzzleHttp\Psr7\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Kamansoft\Klorchid\Models\Kuser;


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
		if (config('auth.providers.users.model') !== Kuser::class) {
            throw new \Exception('Klorchid package needs the user model auth provider setted as as ' . Kuser::class . ' type, instead ' . config('auth.providers.users.model') . ' found');
        }
	    //\DeBugbaR::info('KlorchidKuserEnabled Middleware hanlded method was called');
        if (Auth::user()->status == true){
            //\DeBugbaR::info('klorchidKuserEabled Middleware Kuser is enabled');
           return  $next($request);
        }else{
           return abort(403);
        }
	}
}