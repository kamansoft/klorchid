<?php
declare(strict_types=1);

namespace Kamansoft\Klorchid\Screens;

use Kamansoft\Klorchid\Contracts\KlorchidMultimodeInterface;
use Kamansoft\Klorchid\Contracts\KlorchidPermissionsInterface;
use Kamansoft\Klorchid\Screens\Traits\KlorchidScreenLayoutElementsTrait;
use Kamansoft\Klorchid\Traits\KlorchidMultiModeTrait;
use Kamansoft\Klorchid\Traits\KlorchidPermissionsTrait;
use Orchid\Screen\Screen;

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


    /**
     * @throws \ReflectionException
     * @throws \Exception
     */
    public function __construct()
    {

        $this->initAvailableModes(static::MODES_METHODS_NAME_SUFFIX)->setMode('default');

    }


    public function layoutElements(): array
    {
        $layoutModeMethod = $this->getModeMethod($this->getMode());
        return $this->$layoutModeMethod();
    }

    abstract public function defaultModeLayout(): array;

}


