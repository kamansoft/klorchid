<?php


namespace Kamansoft\Klorchid\Layouts;

use Kamansoft\Klorchid\Contracts\KlorchidScreenQueryRepositoryDependentInterface;
use Kamansoft\Klorchid\Layouts\Contracts\MultiModeScreensLayoutInterface;
use Kamansoft\Klorchid\Layouts\Contracts\KlorchidModelDependantLayoutInterface;
use Kamansoft\Klorchid\Layouts\Traits\MultiModeScreensLayoutTrait;
use Kamansoft\Klorchid\Layouts\Traits\KlorchidScreenQueryRepositoryDependantLayoutTrait;
use Kamansoft\Klorchid\Screens\Contracts\KlorchidScreenLayoutElementsInterface;
use Kamansoft\Klorchid\Traits\KlorchidMultiModeTrait;
use Kamansoft\Klorchid\Traits\KlorchidScreenQueryRepositoryDependentTrait;
use Kamansoft\Klorchid\Layouts\Traits\KlorchidModelDependantLayoutTrait;
use Orchid\Screen\Layouts\Rows;
use Orchid\Screen\Field;

abstract class MultiModeScreenLayout extends KlorchidBasicLayout implements  MultiModeScreensLayoutInterface
{

    use MultiModeScreensLayoutTrait;
}
