<?php

namespace Kamansoft\Klorchid\Layouts\Traits;


use Illuminate\Database\Eloquent\Model;
use Kamansoft\Klorchid\Models\Contracts\KlorchidModelsInterface;
use Kamansoft\Klorchid\Models\KlorchidEloquentModel;
use Kamansoft\Klorchid\Models\KlorchidMultiStatusModel;

trait KlorchidRouteNamesDependantLayoutTrait
{
    use KlorchidScreenQueryRepositoryDependantLayoutTrait;

    private static string $screen_route_names_keyname = 'action_route_names';


    public function getActionRouteNames()
    {
        return $this->query->get(self::getScreenQueryRouteNamesKeyname());
    }

    public function getActionRouteName(string $key)
    {
        return $this->query->get(self::getScreenQueryRouteNamesKeyname())[$key];
    }

    public static function getScreenQueryRouteNamesKeyname(): string
    {
        return self::$screen_route_names_keyname;
    }

    public function routeNamesDependantScreenQueryRequiredKeys(): array
    {
        return [
            self::getScreenQueryRouteNamesKeyname()
        ];
    }
}
