<?php

namespace Kamansoft\Klorchid\Layouts;

use Kamansoft\Klorchid\KlorchidPermissionTrait;
use Orchid\Screen\Field;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\TextArea;
use Orchid\Screen\Layouts\Rows;
use Kamansoft\Klorchid\Layouts\KlorchidLayoutFieldsTrait;

abstract class KlorchidForm extends Rows {

	use KlorchidPermissionTrait;
    use KlorchidLayoutFieldsTrait;

	private bool $return_pk_field = false;
	private bool $return_blaming_fields = false;
	private bool $return_status_field = false;
	private bool $return_status_fields = false;


	
	public function setPkField(bool $value = true) {
		$this->return_pk_field = $value;
		return $this;
	}

	public function setBlamingFields(bool $value = true) {
		$this->return_blaming_fields = $value;
		return $this;
	}

	public function setStatusField(bool $value = true) {
		$this->return_status_field = $value;
		return $this;
	}
	public function setStatusFields(bool $value = true) {
		$this->return_status_fields = $value;
		return $this;
	}




    private function checkScreenQueryAttributes() {
    
        collect(config('klorchid.screen_query_required_elements'))->map(function ($element_key) {
            if (is_null($this->query->get($element_key))) {
                throw new \Exception("\"$element_key\" key was not found. '" . self::class . "' instances needs the \"$element_key\" key at the screen query returned array", 1);
            }
        });
        return $this;
    }

	public function fields(): array
	{
		$this->checkScreenQueryAttributes();

		$fields_to_return = [];

		$fields_to_return = $this->formFields();

		//add id field
		if ($this->return_pk_field) {
			array_unshift($fields_to_return, $this->getPkField());
		}
		//add status field
		if ($this->return_status_field === true and $this->return_status_fields === false) {
			$fields_to_return[] = $this->getStatusField();
		}
		//add status reason field
		if ($this->return_status_fields === true) {
			$fields_to_return = array_merge($fields_to_return, $this->getStatusFields());
		}
		//add blaming fields
		if ($this->return_blaming_fields === true) {
			$fields_to_return = array_merge($fields_to_return, $this->getBlamingFields());
		}

		return $fields_to_return;
	}



	abstract public function formFields() : array;
}
