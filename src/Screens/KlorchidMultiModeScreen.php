<?php
declare(strict_types=1);

namespace Kamansoft\Klorchid\Screens;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Http\FormRequest;
use Kamansoft\Klorchid\Contracts\KlorchidMultimodeInterface;
use Kamansoft\Klorchid\Screens\Traits\KlorchidScreenLayoutElementsTrait;
use Kamansoft\Klorchid\Traits\KlorchidMultiModeTrait;
use Orchid\Screen\Screen;

abstract class KlorchidMultiModeScreen extends Screen implements KlorchidMultimodeInterface
{
    use KlorchidMultiModeTrait;
    use KlorchidScreenLayoutElementsTrait;

    const METHODS_MODES_NAME_SUFFIX = 'ModeLayout';

    public function __construct()
    {
        $this->initAvailableModes(self::METHODS_MODES_NAME_SUFFIX)->setMode('default');
    }

    public function layoutElements(): array
    {
        $layoutModeMethod = $this->getModeMethod($this->getMode());
        return $this->$layoutModeMethod();
    }

    abstract public function defaultModeLayout(): array;

}
