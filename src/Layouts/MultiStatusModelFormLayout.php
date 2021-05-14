<?php


namespace Kamansoft\Klorchid\Layouts;


use Kamansoft\Klorchid\Contracts\KlorchidScreenQueryRepositoryDependentInterface;
use Kamansoft\Klorchid\Layouts\Contracts\MultiModeScreensLayoutInterface;
use Kamansoft\Klorchid\Layouts\Contracts\MultiStatusModelLayoutInterface;
use Kamansoft\Klorchid\Layouts\Contracts\KlorchidModelDependantLayoutInterface;
use Kamansoft\Klorchid\Layouts\Traits\MultiStatusModelLayoutTrait;
use Kamansoft\Klorchid\Layouts\Traits\KlorchidModelDependantLayoutTrait;
use Kamansoft\Klorchid\Layouts\Traits\KlorchidScreenQueryRepositoryDependantLayoutTrait;
use Orchid\Screen\Layouts\Rows;
use Orchid\Screen\Field;

abstract class MultiStatusModelFormLayout extends KlorchidBasicFormLayout
    implements KlorchidModelDependantLayoutInterface, MultiStatusModelLayoutInterface
{

    use KlorchidModelDependantLayoutTrait;
    use MultiStatusModelLayoutTrait;



}