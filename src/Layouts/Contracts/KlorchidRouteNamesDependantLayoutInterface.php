<?php


namespace Kamansoft\Klorchid\Layouts\Contracts;


interface KlorchidRouteNamesDependantLayoutInterface
{
    /**
     * @return string
     */
    public static function getScreenRouteNamesKeyname(): string;

    /**
     * @return string
     */
    public static function getScreenQueryRouteNamesKeyname(): string;

    /**
     * @return array
     */
    public function getActionRouteNames(): array;

    /**
     * @param string $action
     * @return mixed
     * @throws \Exception
     */
    public function getRouteNameFromAction(string $action);

    /**
     * @param string $route_name
     * @return string
     * @throws \Exception
     */
    public function getActionFromRouteName(string $route_name): string;

    public function routeNamesDependantScreenQueryRequiredKeys(): array;

}