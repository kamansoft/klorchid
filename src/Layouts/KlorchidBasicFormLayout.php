<?php


namespace Kamansoft\Klorchid\Layouts;


use Illuminate\Support\Collection;

use Kamansoft\Klorchid\Contracts\KlorchidScreenQueryRepositoryDependentInterface;
use Kamansoft\Klorchid\Layouts\Contracts\KlorchidModelDependantLayoutInterface;
use Kamansoft\Klorchid\Layouts\Traits\KlorchidScreenQueryRepositoryDependantLayoutTrait;
use Kamansoft\Klorchid\Traits\KlorchidScreenQueryRepositoryDependentTrait;
use Orchid\Screen\Field;
use Orchid\Screen\Layouts\Rows;



abstract  class KlorchidBasicFormLayout extends Rows
    implements KlorchidScreenQueryRepositoryDependentInterface
{
    use KlorchidScreenQueryRepositoryDependentTrait;
    use KlorchidScreenQueryRepositoryDependantLayoutTrait;
}
