<?php
declare(strict_types=1);

namespace Kamansoft\Klorchid\Traits;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Orchid\Support\Facades\Dashboard;


trait KlorchidPermissionsTrait
{


    /**
     * retrieves all the permissions registered on the system
     * @return \Illuminate\Support\Collection
     */
    public static function getAllSystemPermissions(): Collection
    {
        return Dashboard::getAllowAllPermission();
    }


    public function permissionExists(string $perm, ?Collection $perms_collection = null): bool
    {
        $perms_collection = $perms_collection ?? self::getAllSystemPermissions();
        return $perms_collection->contains($perm);
    }

    public function loggedUserHasPermission(string $perm): bool
    {

        return (Auth::check() && !is_null(Auth::user()->hasAccess($perm))) ? Auth::user()->hasAccess($perm) : false;
    }


    public function loggedUserHasPermissionOrAbort(string $perm): bool
    {
        if ($this->loggedUserHasPermission($perm)) {
            return true;
        } else {
            abort(403);
            return false;
        }
    }


}