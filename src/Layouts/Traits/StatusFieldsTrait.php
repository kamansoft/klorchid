<?php


namespace Kamansoft\Klorchid\Layouts\Traits;

use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\TextArea;

trait StatusFieldsTrait
{
	public function getStatusFields($data_keyname,$field_class) : array
	{
		return [
			$this->getStatusField($data_keyname,$field_class),
			$this->getStatusReasonField($data_keyname,$field_class),
		];
	}

	public function getStatusField($data_keyname, $field_class = 'form-control'): Field{

		return Input::make(implodeWithDot($data_keyname,'stringStatus'))
			->class($field_class) //. $this->getFieldCssClass($model))
			->type('text')
			->title(__('Current Status') . ':')
			->canSee($this->query->get($data_keyname)->exists)
			->disabled(true);
	}

	public function getStatusReasonField($data_keyname, $field_class = 'form-control'): Field{


		return TextArea::make(implodeWithDot($data_keyname,'cur_status_reason'))
			->class($field_class)
			->title(__('Current Status Reason') . ': ')
			->canSee($this->query->get($data_keyname)->exists)
			->disabled(true);
	}
}