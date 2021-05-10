<?php


namespace Kamansoft\Klorchid\Layouts;


use Kamansoft\Klorchid\Layouts\Contracts\MultiModeScreensLayoutInterface;
use Kamansoft\Klorchid\Layouts\Contracts\MultiStatusModelLayoutInterface;
use Kamansoft\Klorchid\Layouts\Contracts\KlorchidModelDependantLayoutInterface;
use Kamansoft\Klorchid\Layouts\KlorchidBasicLayout;
use Kamansoft\Klorchid\Layouts\Traits\MultiModeScreensLayoutTrait;
use Kamansoft\Klorchid\Layouts\Traits\MultiStatusModelLayoutTrait;
use Kamansoft\Klorchid\Layouts\Traits\KlorchidModelDependantLayoutTrait;
use Orchid\Screen\Field;

abstract class KlorchidLayout extends KlorchidBasicLayout implements KlorchidModelDependantLayoutInterface,MultiStatusModelLayoutInterface
{
    use KlorchidModelDependantLayoutTrait;
    use MultiStatusModelLayoutTrait;

}