<?php


namespace Kamansoft\Klorchid\Layouts\Contracts;


interface KlorchidRouteNamesDependantLayoutInterface
{
    public function getActionRouteNames();

    public static function getScreenQueryRouteNamesKeyname(): string;

    public function routeNamesDependantScreenQueryRequiredKeys(): array;
}