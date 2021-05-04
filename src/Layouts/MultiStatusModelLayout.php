<?php


namespace Kamansoft\Klorchid\Layouts;


use Kamansoft\Klorchid\Contracts\KlorchidScreenQueryValidatableInterface;
use Kamansoft\Klorchid\Layouts\Contracts\MultiModeScreenLayoutsInterface;
use Kamansoft\Klorchid\Layouts\Contracts\MultiStatusModelLayoutInterface;
use Kamansoft\Klorchid\Layouts\Contracts\ScreenQueryDataBasedLayoutInterface;
use Kamansoft\Klorchid\Layouts\Traits\MultiStatusModelLayoutTrait;
use Kamansoft\Klorchid\Layouts\Traits\ScreenQueryFormDataLayoutTrait;
use Kamansoft\Klorchid\Layouts\Traits\ScreenQueryValidationForLayoutsTrait;
use Orchid\Screen\Layouts\Rows;
use Orchid\Screen\Field;

abstract class MultiStatusModelLayout extends KlorchidBasicLayout implements ScreenQueryDataBasedLayoutInterface, MultiStatusModelLayoutInterface
{

    use MultiStatusModelLayoutTrait;



}