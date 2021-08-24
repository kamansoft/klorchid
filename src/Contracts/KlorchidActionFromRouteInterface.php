<?php

namespace Kamansoft\Klorchid\Contracts;


interface KlorchidActionFromRouteInterface
{
    /**
     * @return string
     * @throws \Exception
     */
    public function getActionFromCurrentRoute():string;

    /**
     *
     * @param string $route_name
     * @return string
     * @throws \Exception
     */
    public function getActionFromRouteName(string $route_name):string;

    /**
     * @return string
     * @throws \Exception
     */
    public function checkActionRoutesMapAttribute():string;

    /**
     * @param string $action
     * @return string
     * @throws \Exception
     */
    public function getRouteNameFromAction(string $action): string;

}