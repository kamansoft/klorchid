<?php

namespace Kamansoft\Klorchid\Layouts;

use Kamansoft\Klorchid\KlorchidPermissionTrait;
use Orchid\Screen\Layouts\Rows;
use Kamansoft\Klorchid\Layouts\Traits\KlorchidLayoutsTrait;
use Kamansoft\Klorchid\Layouts\Traits\KlorchidFormLayoutsTrait;
use Kamansoft\Klorchid\Layouts\Traits\KlorchidMultimodeScreenFormLayoutsTrait;
use Kamansoft\Klorchid\Layouts\Contracts\KlorchidLayoutsInterface;
use Kamansoft\Klorchid\Layouts\Traits\KlorchidMultimodeScreenLayoutsTrait;



abstract class KlorchidMultiModeScreenFormsLayout extends KlorchidFormLayout  {

	use KlorchidPermissionTrait;
	use KlorchidMultimodeScreenFormLayoutsTrait;



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



	public function fields(): array
	{


		$fields_to_return = parent::fields();

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




}
