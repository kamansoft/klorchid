<?php


namespace Kamansoft\Klorchid\Layouts;

use Orchid\Screen\Layouts\Rows;
use Kamansoft\Klorchid\Layouts\Traits\KlorchidFormLayoutsTrait;
use Kamansoft\Klorchid\Layouts\Traits\KlorchidLayoutsTrait;
use Kamansoft\Klorchid\Layouts\Contracts\KlorchidLayoutsInterface;

abstract class KlorchidFormLayout extends Rows  Implements KlorchidLayoutsInterface

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

    abstract public function formFields() : array;
}