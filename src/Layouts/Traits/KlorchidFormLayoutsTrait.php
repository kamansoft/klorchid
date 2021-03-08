<?php

namespace Kamansoft\Klorchid\Layouts\Traits;

use Orchid\Screen\Field;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\TextArea;

trait KlorchidFormLayoutsTrait {

	public function getPkField(): Field{
		$model = $this->query->get(model_keyname());

		$pk_field_name = $model->getKeyName();
		$field_class = $this->klorchidFieldStatusClass();

		return Input::make(model_keyname($pk_field_name))
			->type('text')
			->max(255)
			->title(__(ucfirst($pk_field_name)))
			->class($field_class) //. $this->getFieldCssClass($model))
			->disabled(true)
			->canSee($model->exists);
	}

	public function klorchidFieldStatusClass(string $extra = '',  ? object $element = null) {
		$element = $element ?? $this->query->get(model_keyname());
		$to_return = 'text-success';
		if ($this->modelIsProtected($element)) {

			$to_return = 'text-danger';
		}
		//dd($to_return, $this->fieldIsDisabled($element), $element);
		$to_return = $to_return . ' form-control ' . $extra;
		//dd($element,$this->fieldIsDisabled($element),$to_return);
		return $to_return;
	}

	public function modelIsProtected(? object $element = null) : bool{
		$element = $element ?? $this->query->get(model_keyname());

		$to_return = false;
		if (isset($element->status) and $element->status===$element::disabledStatus()) {
			$to_return = true;
		}
		
		return $to_return;
	}

	public function getStatusFields() : array
	{
		return [
			$this->getStatusField(),
			$this->getStatusReasonField(),
		];
	}

	public function getStatusField(): Field{
		$can_see = $this->query->get(model_keyname())->exists;
		$field_class = $this->klorchidFieldStatusClass();
		return Input::make(model_keyname('stringStatus'))
			->class($field_class) //. $this->getFieldCssClass($model))
			->type('text')
			->title(__('Current Status') . ':')
			->canSee($can_see)
			->disabled(true);
	}

	public function getStatusReasonField(): Field{
		$can_see = $this->query->get(model_keyname())->exists;
		$field_class = $this->klorchidFieldStatusClass();
		return TextArea::make(model_keyname('cur_status_reason'))
			->class($field_class)
			->title(__('Current Status Reason') . ': ')
			->canSee($can_see)
			->disabled(true);
	}

	public function getBlamingFields(): array
	{
		$field_class = 'form-control text-dark'; //$this->klorchidFieldClass();
		$can_see = $this->query->get(model_keyname())->exists;
		return [
			Input::make(model_keyname('creator.name'))
				->class($field_class)
				->type('text')
				->title(__('Created by') . ':')
				->canSee($can_see)
				->disabled(true),

			Input::make(model_keyname('created_at'))
				->class($field_class)
				->type('text')
				->title(__('Creation date') . ':')
				->canSee($can_see)
				->disabled(true),
			Input::make(model_keyname('updater.name'))
				->class($field_class)
				->type('text')
				->title(__('Updated by') . ':')
				->canSee($can_see)
				->disabled(true),
			Input::make(model_keyname('updated_at'))
				->class($field_class)
				->type('text')
				->title(__('Update date') . ':')
				->canSee($can_see)
				->disabled(true),

		];
	}
}