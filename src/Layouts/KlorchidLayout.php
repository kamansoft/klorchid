<?php


namespace Kamansoft\Klorchid\Layouts;


use Kamansoft\Klorchid\Layouts\Contracts\MultiModeScreenLayoutsInterface;
use Kamansoft\Klorchid\Layouts\Contracts\MultiStatusModelLayoutInterface;
use Kamansoft\Klorchid\Layouts\Contracts\ScreenQueryDataBasedLayoutInterface;
use Kamansoft\Klorchid\Layouts\KlorchidBasicLayout;
use Kamansoft\Klorchid\Layouts\Traits\MultiModeScreenLayoutTrait;
use Kamansoft\Klorchid\Layouts\Traits\MultiStatusModelLayoutTrait;
use Kamansoft\Klorchid\Layouts\Traits\ScreenQueryDataBasedLayoutTrait;
use Orchid\Screen\Field;

abstract class KlorchidLayout extends KlorchidBasicLayout implements ScreenQueryDataBasedLayoutInterface, MultiModeScreenLayoutsInterface,MultiStatusModelLayoutInterface
{

    use ScreenQueryDataBasedLayoutTrait;
    use MultiStatusModelLayoutTrait;
    use MultiModeScreenLayoutTrait;



}