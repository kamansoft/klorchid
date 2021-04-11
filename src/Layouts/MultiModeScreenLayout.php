<?php


namespace Kamansoft\Klorchid\Layouts;


use Kamansoft\Klorchid\Layouts\Contracts\MultiModeScreenLayoutsInterface;
use Kamansoft\Klorchid\Layouts\Contracts\ScreenQueryDataBasedLayoutInterface;
use Kamansoft\Klorchid\Layouts\Traits\MultiModeScreenLayoutTrait;
use Kamansoft\Klorchid\Layouts\Traits\ScreenQueryDataBasedLayoutTrait;
use Orchid\Screen\Field;

abstract class MultiModeScreenLayout extends KlorchidLayout implements MultiModeScreenLayoutsInterface,ScreenQueryDataBasedLayoutInterface
{
    use ScreenQueryDataBasedLayoutTrait;
    use MultiModeScreenLayoutTrait;

}
