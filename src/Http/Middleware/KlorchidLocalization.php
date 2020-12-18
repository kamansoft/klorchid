<?php

namespace Kamansoft\Klorchid\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;


class KlorchidLocalization {
	/**
	 * Handle an incoming request.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \Closure  $next
	 * @return mixed
	 */
	public function handle(Request $request, Closure $next) {
		\Debugbar::info(session()->get('locale'));
		\Debugbar::info('session from KlorchidLocalization middleware');
		if (session()->has('locale')) {
			\Debugbar::info('existe locale en session');

			app()->setlocale(session()->get('locale'));
		}
		\Debugbar::info(app()->getLocale());
		\Debugbar::info('status of locale on KlorchidLocalization middleware end');

		return $next($request);
	}
}
