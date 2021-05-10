<?php


namespace Kamansoft\Klorchid\Layouts;


use Illuminate\Support\Str;
use Kamansoft\Klorchid\Layouts\Contracts\KlorchidFormsLayoutInterface;
use Kamansoft\Klorchid\Layouts\Traits\BlamingFields;
use Kamansoft\Klorchid\Layouts\Traits\KlorchidFormLayoutTrait;
use Kamansoft\Klorchid\Layouts\Traits\StatusFieldsTrait;
use Orchid\Screen\Field;

abstract class KlorchidFormLayout extends KlorchidLayout implements KlorchidFormsLayoutInterface
{
    use KlorchidFormLayoutTrait;
}