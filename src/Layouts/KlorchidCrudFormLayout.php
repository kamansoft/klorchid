<?php


namespace Kamansoft\Klorchid\Layouts;


use Kamansoft\Klorchid\Layouts\Contracts\KlorchidFormsLayoutInterface;
use Kamansoft\Klorchid\Layouts\Contracts\MultiModeScreensLayoutInterface;
use Kamansoft\Klorchid\Layouts\Contracts\MultiStatusModelLayoutInterface;
use Kamansoft\Klorchid\Layouts\Contracts\KlorchidModelDependantLayoutInterface;
use Kamansoft\Klorchid\Layouts\KlorchidBasicFormLayout;
use Kamansoft\Klorchid\Layouts\Traits\KlorchidFormLayoutTrait;
use Kamansoft\Klorchid\Layouts\Traits\KlorchidScreenQueryRepositoryDependantLayoutTrait;
use Kamansoft\Klorchid\Layouts\Traits\MultiModeScreensLayoutTrait;
use Kamansoft\Klorchid\Layouts\Traits\MultiStatusModelLayoutTrait;
use Kamansoft\Klorchid\Layouts\Traits\KlorchidModelDependantLayoutTrait;
use Kamansoft\Klorchid\Traits\KlorchidScreenQueryRepositoryDependentTrait;
use Orchid\Screen\Field;

abstract class KlorchidCrudFormLayout extends KlorchidBasicFormLayout
    implements KlorchidModelDependantLayoutInterface, MultiModeScreensLayoutInterface,
    KlorchidFormsLayoutInterface//, MultiStatusModelLayoutInterface

{
    use KlorchidModelDependantLayoutTrait;
    use MultiModeScreensLayoutTrait;
    use MultiStatusModelLayoutTrait;
    use KlorchidFormLayoutTrait;
}