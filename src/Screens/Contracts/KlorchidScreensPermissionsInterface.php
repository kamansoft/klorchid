<?php


namespace Kamansoft\Klorchid\Screens\Contracts;


interface KlorchidScreensPermissionsInterface
{
    /**
     * Retrives an assoiative array with the name of an action as key and the permission for that action
     * @return array
     */
    //public function actionPermissionsMap():array;

    public function getPermissionForAction(string $action): string;

    public function loggedUserHasActionPermission(string $action): bool;

    public function loggedUserHasActionPermissionOrAbort(string $acton): bool;
}