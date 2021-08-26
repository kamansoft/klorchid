<?php

namespace Kamansoft\Klorchid\Traits;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Route;

/**
 *
 * @property array $action_route_names_map
 *
 */
trait KlorchidActionFromRouteTrait
{


    /**
     * @return string
     * @throws \Exception
     */
    public function getActionFromCurrentRoute():string
    {
        return $this->getActionFromRouteName(Route::currentRouteName());
    }

    /**
     *
     * @param string $route_name
     * @return string
     * @throws \Exception
     */
    public function getActionFromRouteName(string $route_name):string
    {
        $this->checkActionRoutesMapAttribute();
        $action = array_search($route_name, static::$action_route_names_map, true);
        if ($action) {
            return $action;
        }

        $message = "An action for \"$route_name\" route was not found in \"action_route_names_map\" attribute array at: " . static::class;
        Log::error($message);
        throw new \Exception($message);

    }

    /**
     * @return string
     * @throws \Exception
     */
    public function checkActionRoutesMapAttribute():string
    {
        if (empty(static::$action_route_names_map)) {

            $message = static::class . ' needs a non empty static array attribute "$action_route_names_map" to be used on action detection based on current laravel route ';
            Log::error($message);
            throw new \Exception($message);

        }
        return true;
    }

    public function getActionRoutesMapAttribute():array
    {
        $this->checkActionRoutesMapAttribute();
        return static::$action_route_names_map;
    }

    /**
     * @param string $action
     * @return string
     * @throws \Exception
     */
    public function getRouteNameFromAction(string $action): string
    {
        $this->checkActionRoutesMapAttribute();
        if (!isset(static::$action_route_names_map[$action])) {
            $message = "A route for \"$action\" action was not found in \"action_route_names_map\" attribute array at: " . static::class;
            Log::error($message);
            throw new \Exception($message);

        }
        return static::$action_route_names_map[$action];
    }


}
