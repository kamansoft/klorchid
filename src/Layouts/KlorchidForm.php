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



	public function getPkField(): Field{
		$pk_field_name = $this->getModel()->getKeyName();
        $field_class = $this->klorchidFieldStatusClass();

		return Input::make(config('klorchid.screen_query_required_elements.element_to_display') . '.' . $pk_field_name)
			->type('text')
			->max(255)
			->title(__(ucfirst($pk_field_name)))
			->class($field_class) //. $this->getFieldCssClass($model))
			->disabled(true)
			->canSee($this->getScreenMode() !== 'create');
	}

	public function getStatusField(): Field {
        $field_class = $this->klorchidFieldStatusClass();
		return Input::make(config('klorchid.screen_query_required_elements.element_to_display') . '.stringStatus')
			->class($field_class) //. $this->getFieldCssClass($model))
			->type('text')
			->title(__('Current Status') . ':')
			->disabled(true);
	}
	public function getStatusReasonField(): Field {
        $field_class = $this->klorchidFieldClass();
		return TextArea::make(config('klorchid.screen_query_required_elements.element_to_display') . '.cur_status_reason')
			->class($field_class)
			->title(__('Current Status Reason') . ': ')
			->disabled(true);
	}

	public function getStatusFields(): array
	{
		return [
			$this->getStatusField(),
			$this->getStatusReasonField(),
		];
	}

	public function getBlamingFields(): array
	{
		$field_class = $this->klorchidFieldClass();
		return [
			Input::make(config('klorchid.screen_query_required_elements.element_to_display') . '.creatorName')
				->class($field_class)
				->type('text')
				->title(__('Created by') . ':')
				->disabled(true),
			Input::make(config('klorchid.screen_query_required_elements.element_to_display') . '.created_at')
				->class($field_class)
				->type('text')
				->title(__('Creation date') . ':')
				->disabled(true),
			Input::make(config('klorchid.screen_query_required_elements.element_to_display') . '.updaterName')
				->class($field_class)
				->type('text')
				->title(__('Updated by') . ':')
				->disabled(true),
			Input::make(config('klorchid.screen_query_required_elements.element_to_display') . '.updated_at')
				->class($field_class)
				->type('text')
				->title(__('Update date') . ':')
				->disabled(true),

		];
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
