<?php

namespace Kamansoft\Klorchid\Layouts;

use Orchid\Screen\Layouts\Rows;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\TextArea;
use Orchid\Screen\Field;

abstract class KlorchidForm extends Rows {

	/**
	 * The attributes a screen should pass as query to this object
	 */
	const  QUERY_REQUIRED_ELEMENTS = [
		'item',
		'screenmode'

	];

	private bool $return_pk_field = false;
	private bool $return_blamming_fields = false;
	private bool $return_status_field = false;
	private bool $return_status_fields = false;

	public function setPkField(bool $value=true){
		$this->return_pk_field=$value;
		return $this;
	}

	public function setBlamingFields(bool $value = true) {
		$this->return_blamming_fields = $value;
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

	public function getModel(){
		return $this->query->get('item');
	}
	public function getScreenMode(){
		return $this->query->get('screenmode');
	}


	public function getPkField(): Field
    {
    	$pk_field_name  =$this->getModel()->getKeyName();

        return Input::make('item.'.$pk_field_name)
            ->type('text')
            ->max(255)
            ->title(__(ucfirst($pk_field_name)))
            ->class('form-control ' )//. $this->getFieldCssClass($model))
            ->disabled(true)
            ->canSee($this->getScreenMode() !== 'create');
    }

    public function getStatusField(): Field
    {
        return Input::make('item.stringStatus')
            ->class('form-control ' )//. $this->getFieldCssClass($model))
            ->type('text')
            ->title(__('Current Status') . ':')
            ->disabled(true);

    }
    public function getStatusReasonField():Field{
    	return TextArea::make('item.cur_status_reason')
    		->class('form-control')
    		->title(__('Current Status Reason').': ')
    		->disabled(true);
    }

    public function getStatusFields():array{
    	return [
    		$this->getStatusField(),
    		$this->getStatusReasonField()
    	];
    }


    public function getBlamingFields(?Model $model = null): array
    {
        
        $field_class  = '';//$this->getFieldCssClass($model);
        return [
            Input::make('element.creatorName')
                ->class('form-control ' . $field_class )
                ->type('text')
                ->title(__('Created by') . ':')
                ->disabled(true),
            Input::make('element.created_at')
                ->class('form-control ' . $field_class)
                ->type('text')
                ->title(__('Creation date') . ':')
                ->disabled(true),
            Input::make('element.updaterName')
                ->class('form-control ' . $field_class)
                ->type('text')
                ->title(__('Updated by') . ':')
                ->disabled(true),
            Input::make('element.updated_at')
                ->class('form-control ' . $field_class)
                ->type('text')
                ->title(__('Update date') . ':')
                ->disabled(true)

        ];
    }






	private function checkScreenQueryAttributes() {

		collect(self::QUERY_REQUIRED_ELEMENTS)->map(function($element_key){
			if (is_null($this->query->get($element_key))){
				throw new \Exception("\"$element_key\" element was not found. '".self::class."' instances needs the \"$element_key\" element in the screen query returned array", 1);
				
			}
		});
		return $this;
	}

	public function fields(): array{

		$this->checkScreenQueryAttributes();

		$this->getPkField();

		$fields_to_return = [];

		$fields_to_return = $this->formFields();




		//dd($this->return_pk_field);
		if ($this->return_pk_field) {
			array_unshift($fields_to_return,$this->getPkField());
		}

		if ($this->return_status_field === true and $this->return_status_fields === false){
			$fields_to_return[]=$this->getStatusField();
		}

		if ($this->return_status_fields === true){

			$fields_to_return=array_merge($fields_to_return,$this->getStatusFields());
		}


		return $fields_to_return;
	}

	abstract public function formFields(): array;

}
