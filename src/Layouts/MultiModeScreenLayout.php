<?php


namespace Kamansoft\Klorchid\Layouts;

use Kamansoft\Klorchid\Contracts\KlorchidScreenQueryValidatableInterface;
use Kamansoft\Klorchid\Layouts\Contracts\MultiModeScreenLayoutsInterface;
use Kamansoft\Klorchid\Layouts\Contracts\ScreenQueryDataBasedLayoutInterface;
use Kamansoft\Klorchid\Layouts\Traits\MultiModeScreenLayoutTrait;
use Kamansoft\Klorchid\Layouts\Traits\ScreenQueryValidationForLayoutTrait;
use Kamansoft\Klorchid\Traits\KlorchidScreenQueryValidatable;
use Kamansoft\Klorchid\Layouts\Traits\ScreenQueryDataBasedLayoutTrait;
use Orchid\Screen\Layouts\Rows;
use Orchid\Screen\Field;

abstract class MultiModeScreenLayout extends Rows implements KlorchidScreenQueryValidatableInterface, MultiModeScreenLayoutsInterface
{
    //use ScreenQueryDataBasedLayoutTrait;
    use ScreenQueryValidationForLayoutTrait;
    use MultiModeScreenLayoutTrait;

    public function screenQueryRequiredKeys(): array
    {
        return [];
    }

    public function __construct()
    {
        $this->setScreenQueryRequiredKeys();
    }
}
