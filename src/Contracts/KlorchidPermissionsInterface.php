<?php


namespace Kamansoft\Klorchid\Contracts;

use Illuminate\Support\Collection;
interface KlorchidPermissionsInterface
{



    public static function getAllSystemPermissions(): Collection;

    public function permissionExists(string $perm): bool;

    public function loggedUserHasPermission(string $perm): bool;

    public function loggedUserHasPermissionOrAbort(string $perm): bool;
}