<?php
declare(strict_types=1);

namespace Kamansoft\Klorchid\Screens;

use Kamansoft\Klorchid\Contracts\KlorchidMultimodeInterface;
use Kamansoft\Klorchid\Traits\KlorchidMultiModeTrait;
use Orchid\Screen\Screen;

abstract class KlorchidMultiModeScreen extends Screen implements KlorchidMultimodeInterface
{
    use KlorchidMultiModeTrait;

    const METHODS_MODES_SUFFIX = 'ModeLayout';

    public function __construct()
    {
        $this->setAvailableModes(
            $this->getModesByMethodsName(self::METHODS_MODES_SUFFIX)
        )->setMode('default');
    }

    public function layout(): array
    {
        $current_mode = $this->getMode();
        $layoutModeMethod = $this->getModeMethod($current_mode);
        return $this->$layoutModeMethod();
    }

    abstract public function defaultModeLayout(): array;

}
