<?php 
declare(strict_types=1);
namespace Kamansoft\Klorchid\Traits;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Orchid\Support\Facades\Dashboard;


trait KlorchidPermissionTrait {


	public function permissionExists(string $perm ): bool {
		$perms_collection  = $perms_collection ?? Dashboard::getAllowAllPermission();
		return  $perms_collection->contains($perm);
	}

	public function userHasPermission(string $perm)
    {
        return Auth::user()->hasAccess($perm);
    }


	public function userHasPermissionOrFail(string $perm){
	    if ($this->userHasPermission($perm)){
	        return true;
        }else{
	        abort(403);
	        return false;
        }
    }



}