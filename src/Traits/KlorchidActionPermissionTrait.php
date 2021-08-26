<?php


namespace Kamansoft\Klorchid\Traits;


use Illuminate\Support\Facades\Log;

/**
 * Trait KlorchidScreensPermissionsTrait
 * @property array $action_permissions_map
 * @package Kamansoft\Klorchid\Screens\Traits
 *
 */
trait   KlorchidActionPermissionTrait
{
    use KlorchidPermissionsTrait;

        /**
     * @return string
     * @throws \Exception
     */
    public function checkActionPermissionsMapAttribute():string
    {
        if (empty(static::$action_permissions_map)) {

            $message = static::class . ' needs a non empty static array attribute "$action_permissions_map" to be used on getting the perms depending of oactions actions ';
            Log::error($message);
            throw new \Exception($message);

        }
        return true;
    }

    public function getPermissionForAction(string $action): string
    {
        $this->checkActionPermissionsMapAttribute();
        if (!isset(static::$action_permissions_map[$action])) {
            $message = "A route for \"$action\" action was not found in \"action_permissions_map\" attribute array at: " . static::class;
            Log::error($message);
            throw new \Exception($message);

        }
        return static::$action_permissions_map[$action];
    }




    public function initPermission(): self
    {

        $this->checkActionPermissionsMapAttribute();
        $this->permission = array_values(static::$action_permissions_map);
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
