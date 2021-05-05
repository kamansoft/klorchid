<?php


namespace Kamansoft\Klorchid\Layouts;

use Kamansoft\Klorchid\Contracts\KlorchidScreenQueryRepositoryDependentInterface;
use Kamansoft\Klorchid\Layouts\Contracts\MultiModeScreenLayoutsInterface;
use Kamansoft\Klorchid\Layouts\Contracts\ScreenQueryDataBasedLayoutInterface;
use Kamansoft\Klorchid\Layouts\Traits\MultiModeScreensLayoutTrait;
use Kamansoft\Klorchid\Layouts\Traits\ScreenQueryValidationForLayoutsTrait;
use Kamansoft\Klorchid\Screens\Contracts\KlorchidScreenLayoutElementsInterface;
use Kamansoft\Klorchid\Traits\KlorchidMultiModeTrait;
use Kamansoft\Klorchid\Traits\KlorchidScreenQueryRepositoryDependentTrait;
use Kamansoft\Klorchid\Layouts\Traits\ScreenQueryFormDataLayoutTrait;
use Orchid\Screen\Layouts\Rows;
use Orchid\Screen\Field;

abstract class MultiModeScreenLayout extends KlorchidBasicLayout implements KlorchidScreenLayoutElementsInterface, MultiModeScreenLayoutsInterface
{
    use KlorchidMultiModeTrait;
    use MultiModeScreensLayoutTrait;
}
