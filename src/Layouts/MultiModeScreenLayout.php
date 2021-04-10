<?php


namespace Kamansoft\Klorchid\Layouts;


use Kamansoft\Klorchid\Layouts\Contracts\MultiModeScreenLayoutsInterface;
use Kamansoft\Klorchid\Layouts\Traits\MultiModeScreenLayoutTrait;
use Orchid\Screen\Field;

abstract class MultiModeScreenLayout extends KlorchidLayout implements MultiModeScreenLayoutsInterface
{
    use MultiModeScreenLayoutTrait;

}
