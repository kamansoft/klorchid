<?php


namespace Kamansoft\Klorchid\Layouts;

use Kamansoft\Klorchid\Layouts\Contracts\KlorchidCurdLayoutsInterface;
use Kamansoft\Klorchid\Layouts\Traits\KlorchidFormLayoutsTrait;
use Kamansoft\Klorchid\Layouts\Traits\KlorchidLayoutsTrait;
use Orchid\Screen\Layouts\Rows;

abstract class KlorchidCurdFormLayout extends Rows implements KlorchidCurdLayoutsInterface

{
    use KlorchidLayoutsTrait;
    use KlorchidFormLayoutsTrait;

    public function fields(): array
    {
        $this->checkScreenQueryAttributes();

        $fields_to_return = [];

        $fields_to_return = $this->formFields();


        return $fields_to_return;
    }

    abstract public function formFields(): array;
}