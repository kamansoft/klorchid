<?php


namespace Kamansoft\Klorchid\Screens\Traits;

use Kamansoft\Klorchid\Screens\Contracts\KlorchidScreensPermissionsInterface;
use Kamansoft\Klorchid\Traits\KlorchidPermissionsTrait;

/**
 * Trait KlorchidScreensPermissionsTrait
 * @property array $actionPermissionsMap
 * @package Kamansoft\Klorchid\Screens\Traits
 *
 */
trait   KlorchidScreensPermissionsTrait
{
    use KlorchidPermissionsTrait;


    public function getPermissionForAction(string $action): string
    {
        return $this->actionPermissionsMap[$action];
    }


    public function initPermission(): self
    {


        $this->permission = array_values($this->actionPermissionsMap);
        return $this;
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