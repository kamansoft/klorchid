<?php

namespace Kamansoft\Klorchid\Layouts\Traits;


use Kamansoft\Klorchid\Traits\KlorchidActionFromRouteTrait;

trait KlorchidRouteNamesDependantLayoutTrait
{
    use KlorchidScreenQueryRepositoryDependantLayoutTrait;



    private static string $screen_route_names_keyname = 'action_route_names_map';

    /**
     * @return string
     */
    public static function getScreenRouteNamesKeyname(): string
    {

        return self::$screen_route_names_keyname;
    }


    /**
     * @return array
     */
    public function getActionRouteNames():array
    {
        return $this->query->get(static::getScreenQueryRouteNamesKeyname());
    }

    /**
     * @return string
     */
    public static function getScreenQueryRouteNamesKeyname(): string
    {
        return self::$screen_route_names_keyname;
    }


    /**
     * @param string $action
     * @return mixed
     * @throws \Exception
     */
    public function getRouteNameFromAction(string $action)
    {
        if (!isset($this->getActionRouteNames()[$action])) {
            $message = "A route for \"$action\" action was was not found in the \"".self::$screen_route_names_keyname."\" element of the screen returned query that uses " . static::class ." layaut";
            Log::error($message);
            throw new \Exception($message);

        }
        return $this->getActionRouteNames()[$action];
    }

    /**
     * @param string $route_name
     * @return string
     * @throws \Exception
     */
    public function getActionFromRouteName(string $route_name):string
    {

        $action = array_search($route_name,  $this->getActionRouteNames(), true);
        if ($action) {
            return $action;
        }

        $message = "An action for \"$route_name\" route was not found in the \"".self::$screen_route_names_keyname."\" element of the screen returned query that uses " . static::class ." layaut";
        Log::error($message);
        throw new \Exception($message);

    }

    public function routeNamesDependantScreenQueryRequiredKeys(): array
    {
        return [
            static::getScreenQueryRouteNamesKeyname()
        ];
    }
}
