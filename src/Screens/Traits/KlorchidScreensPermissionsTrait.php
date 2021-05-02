<?php


namespace Kamansoft\Klorchid\Screens\Traits;

use Kamansoft\Klorchid\Screens\Contracts\KlorchidScreensPermissionsInterface;
use Kamansoft\Klorchid\Traits\KlorchidPermissionsTrait;
/**
 * Trait KlorchidScreensPermissionsTrait
 * @method KlorchidScreensPermissionsInterface actionPermissionsMap()
 * @package Kamansoft\Klorchid\Screens\Traits
 *
 */
trait   KlorchidScreensPermissionsTrait
{
    use KlorchidPermissionsTrait;
    public function getPermissionForAction(string $action): string
    {
        return $this->actionPermissionsMap()[$action];
    }

    public function loggedUserHasActionPermission(string $action): bool
    {
        return $this->loggedUserHasPermission($this->getPermissionForAction($action));
    }

    public function loggedUserHasActionPermissionOrAbort(string $action): bool
    {
        return $this->loggedUserHasPermissionOrAbort($this->getPermissionForAction($action));
    }
}