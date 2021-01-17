<?php

use Illuminate\Support\Facades\Route;
use Kamansoft\Klorchid\Http\Controllers\KlorchidLocalizationController;



Route::get('set/locale/{lang}', [KlorchidLocalizationController::class, 'index']);