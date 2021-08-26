<?php


namespace Kamansoft\Klorchid\Contracts;


interface KlorchidActionPermissionInterface
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