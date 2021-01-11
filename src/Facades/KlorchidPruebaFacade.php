<?php

namespace Kamansoft\Klorchid\Facades;

use Illuminate\Support\Facades\Facade;



class KlorchidPruebaFacade extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'klorchid-prueba';
    }
}
