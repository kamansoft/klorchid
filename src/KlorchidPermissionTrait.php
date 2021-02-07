<?php 

namespace Kamansoft\Klorchid;

use Illuminate\Support\Facades\Auth;
use Orchid\Support\Facades\Dashboard;


trait KlorchidPermissionTrait {


	public function isValidPerm(string $perm): bool {
		//dd(Dashboard::getAllowAllPermission());
		return Dashboard::getAllowAllPermission()->get($perm) ? true : false;
	}

	public function userHasPermission(string $perm) {
		return Auth::user()->hasAccess($perm);
	}


}