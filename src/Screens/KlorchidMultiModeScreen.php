<?php
declare(strict_types=1);

namespace Kamansoft\Klorchid\Screens;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Route;
use Kamansoft\Klorchid\Contracts\KlorchidMultimodeInterface;
use Kamansoft\Klorchid\Screens\Traits\KlorchidScreenLayoutElementsTrait;
use Kamansoft\Klorchid\Traits\KlorchidMultiModeTrait;
use Kamansoft\Klorchid\Contracts\KlorchidPermissionsInterface;
use Kamansoft\Klorchid\Traits\KlorchidPermissionsTrait;
use Orchid\Screen\Screen;
use PHPUnit\Util\Exception;

/**
 * Class KlorchidMultiModeScreen
 * @package Kamansoft\Klorchid\Screens
 * @property array $actionRouteNames
 */
abstract class KlorchidMultiModeScreen extends Screen implements KlorchidMultimodeInterface, KlorchidPermissionsInterface
{
    use KlorchidMultiModeTrait;
    use KlorchidScreenLayoutElementsTrait;
    use KlorchidPermissionsTrait;

    public const MODES_METHODS_NAME_SUFFIX = 'ModeLayout';
    protected static string $screen_query_mode_keyname = 'screen_mode';

    /**
     * @throws \ReflectionException
     * @throws \Exception
     */
    public function __construct()
    {

        $this->initAvailableModes(static::MODES_METHODS_NAME_SUFFIX)->setMode('default');

    }



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
        return array_search($action, $this->actionRouteNames, true);
    }

    public function getRouteNameFromAction($action)
    {
        if (!property_exists($this, 'actionRouteNames')) {
            throw new \Exception(static::class . ' $actionRouteNames property is not setted');
        }

        if (!isset($this->actionRouteNames[$action])) {
            throw new \Exception(static::class . "a route for $action not found at actionRouteNames array ");
        }
        return $this->actionRouteNames[$action];
    }

    public function layoutElements(): array
    {
        $layoutModeMethod = $this->getModeMethod($this->getMode());
        return $this->$layoutModeMethod();
    }

    abstract public function defaultModeLayout(): array;

}


