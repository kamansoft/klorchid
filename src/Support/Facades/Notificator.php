<?php


namespace Kamansoft\Klorchid\Support\Facades;

use Kamansoft\Klorchid\Notificator\Notificator as NotificatorClass;

/**
 * Class Notificator
 *
 * @method static NotificatorClass setMode(string $mode)
 * @method static NotificatorClass info(string $message)
 * @method static NotificatorClass success(string $message)
 * @method static NotificatorClass error(string $message)
 * @method static NotificatorClass warning(string $message)
 * @package Kamansoft\Klorchid\Support\Facades
 */
class Notificator extends \Illuminate\Support\Facades\Facade
{
    protected static function getFacadeAccessor()
    {
        return NotificatorClass::class;
    }
}