<?php

namespace Kamansoft\Klorchid\Traits;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Route;

trait KlorchidActionFromRouteTrait
{


    /**
     * @return false|int|string
     */
    public function getActionFromCurrentRoute()
    {

        return $this->getActionFromRouteName(Route::currentRouteName());
    }

    /**
     * @param string $action
     * @return false|int|string
     */
    public function getActionFromRouteName(string $action)
    {
        $this->checkActionRoutesMapAttribute();
        return array_search($action, static::$action_route_names_map, true);
    }

    public function checkActionRoutesMapAttribute()
    {
        if (empty(static::$action_route_names_map)) {
            $message = static::class . ' needs a non empty static array attribute "$action_route_names_map" to be used on action detection based on current laravel route ';

            throw new \Exception($message);
            Log::error($message);

        }
        return true;
    }

    public function getRouteNameFromAction($action)
    {
        $this->checkActionRoutesMapAttribute();
        if (!isset(static::$action_route_names_map[$action])) {
            $message = "A route for \"$action\" action was not found in \"action_route_names_map\" attribute array at: " . static::class;
            throw new \Exception($message);
            Log::error($message);
        }
        return static::$action_route_names_map[$action];
    }


}