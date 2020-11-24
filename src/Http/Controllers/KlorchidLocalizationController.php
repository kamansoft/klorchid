<?php

namespace Kamansoft\Klorchid\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\App;

class KlorchidLocalizationController extends Controller {
	public function index(Request $request, $locale) {
		if (!in_array($locale, config('klorchid.aviable_locales'))) {
			App::abort(404);
		}
		app()->setlocale($locale);
		session()->put('locale', $locale);

		return redirect()->back();
	}
}
