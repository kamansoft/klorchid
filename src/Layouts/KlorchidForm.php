<?php

namespace Kamansoft\Klorchid\Layouts;

use Kamansoft\Klorchid\KlorchidPermissionTrait;
use Orchid\Screen\Field;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\TextArea;
use Orchid\Screen\Layouts\Rows;

abstract class KlorchidForm extends Rows {

	use KlorchidPermissionTrait;

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

	public function getModel() {
		$query_key_name = config('klorchid.screen_query_required_elements.element_to_display');

		return $query_key_name ? $this->query->get($query_key_name) : null;
	}
	public function getScreenMode() {

		$query_key_name = config('klorchid.screen_query_required_elements.screen_mode_layout');

		return $query_key_name ? $this->query->get($query_key_name) : null;

	}

	public function getScreenModePerm(string $mode) {

		$query_key_name = config('klorchid.screen_query_required_elements.screen_mode_perms');

		return $query_key_name ? $this->query->get($query_key_name)->get($mode) : null;

	}

	public function getPkField(): Field{
		$pk_field_name = $this->getModel()->getKeyName();

		return Input::make(config('klorchid.screen_query_required_elements.element_to_display') . '.' . $pk_field_name)
			->type('text')
			->max(255)
			->title(__(ucfirst($pk_field_name)))
			->class('form-control ') //. $this->getFieldCssClass($model))
			->disabled(true)
			->canSee($this->getScreenMode() !== 'create');
	}

	public function getStatusField(): Field {
		return Input::make(config('klorchid.screen_query_required_elements.element_to_display') . '.stringStatus')
			->class('form-control ') //. $this->getFieldCssClass($model))
			->type('text')
			->title(__('Current Status') . ':')
			->disabled(true);
	}
	public function getStatusReasonField(): Field {
		return TextArea::make(config('klorchid.screen_query_required_elements.element_to_display') . '.cur_status_reason')
			->class('form-control')
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
		$field_class = ''; //$this->getFieldCssClass($model);
		return [
			Input::make(config('klorchid.screen_query_required_elements.element_to_display') . '.creatorName')
				->class('form-control ' . $field_class)
				->type('text')
				->title(__('Created by') . ':')
				->disabled(true),
			Input::make(config('klorchid.screen_query_required_elements.element_to_display') . '.created_at')
				->class('form-control ' . $field_class)
				->type('text')
				->title(__('Creation date') . ':')
				->disabled(true),
			Input::make(config('klorchid.screen_query_required_elements.element_to_display') . '.updaterName')
				->class('form-control ' . $field_class)
				->type('text')
				->title(__('Updated by') . ':')
				->disabled(true),
			Input::make(config('klorchid.screen_query_required_elements.element_to_display') . '.updated_at')
				->class('form-control ' . $field_class)
				->type('text')
				->title(__('Update date') . ':')
				->disabled(true),

		];
	}

	private function checkScreenQueryAttributes() {
		collect(config('klorchid.screen_query_required_elements'))->map(function ($element_key) {
			if (is_null($this->query->get($element_key))) {
				throw new \Exception("\"$element_key\" element was not found. '" . self::class . "' instances needs the \"$element_key\" element in the screen query returned array", 1);
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

	//perhabs this can go in a trait to make it  usable in other layout class
	public function isEditable( ? object $element = null) {
		$to_return = false;
		$element = $element ?? $this->getModel();


		if ($this->isDissabled($element) === false) {

			$to_return = true;
			if (
				$this->getScreenMode() === 'create' and
				!is_null($this->getScreenModePerm('create')) and
				$this->userHasPermission($this->getScreenModePerm('create')) === false
			) {
				$to_return = false;
			} elseif (
				$this->getScreenMode() === 'edit' and
				!is_null($this->getScreenModePerm('edit')) and
				$this->userHasPermission($this->getScreenModePerm('edit')) === false
			) {
                $to_return= false;
			}
		}

		dd(
			$this->getScreenMode(),
			!is_null($this->getScreenModePerm('edit')),
			$this->userHasPermission($this->getScreenModePerm('edit')),
			$to_return
		);
		return $to_return;
	}

	public function isDissabled( ? object $element = null) : bool{
		$element = $element ?? $this->getModel();
		$to_return = false;
		if (property_exists($element, 'status')) {
			$to_return = !boolval($element->status);
		}
		return $to_return;
	}

	abstract public function formFields() : array;
}
