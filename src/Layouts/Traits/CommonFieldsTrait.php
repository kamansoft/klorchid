<?php


namespace Kamansoft\Klorchid\Layouts\Traits;

use Orchid\Screen\Fields\Input;

trait CommonFieldsTrait
{


    public function getBlamingFields($data_keyname, $field_class): array
    {
        return [
            $this->getCreatorNameField($data_keyname, $field_class),
            $this->getCreatedAtField($data_keyname, $field_class),
            $this->getUpdaterNameField($data_keyname, $field_class),
            $this->getUpdatedAtField($data_keyname, $field_class),
        ];
    }

    public function getCreatorNameField($data_keyname, $field_class = 'form-control'): Field
    {
        return Input::make(implodeWithDot($data_keyname, 'creator.name'))
            ->class($field_class)
            ->type('text')
            ->title(__('Created by') . ':')
            ->canSee($this->query->get($data_keyname)->exists)
            ->disabled(true);
    }

    public function getCreatedAtField($data_keyname, $field_class = 'form-control'): Field
    {

        return Input::make(implodeWithDot($data_keyname, 'created_at'))
            ->class($field_class)
            ->type('text')
            ->title(__('Creation date') . ':')
            ->canSee($this->query->get($data_keyname)->exists)
            ->disabled(true);
    }

    public function getUpdaterNameField($data_keyname, $field_class = 'form-control'): Field
    {
        return Input::make(implodeWithDot($data_keyname, 'updater.name'))
            ->class($field_class)
            ->type('text')
            ->title(__('Updated by') . ':')
            ->canSee($this->query->get($data_keyname)->exists)
            ->disabled(true);
    }

    public function getUpdatedAtField($data_keyname, $field_class = 'form-control'): Field
    {
        return Input::make(implodeWithDot($data_keyname, 'updated_at'))
            ->class($field_class)
            ->type('text')
            ->title(__('Update date') . ':')
            ->canSee($this->query->get($data_keyname)->exists)
            ->disabled(true);
    }

    public function getPkField($data_keyname,$field_class): Field
    {
        $model = $this->query->get($data_keyname);

        $pk_field_name = $model->getKeyName();

        return Input::make(implodeWithDot($data_keyname,$pk_field_name))
            ->type('text')
            ->max(255)
            ->title(__(ucfirst($pk_field_name)))
            ->class($field_class) //. $this->getFieldCssClass($model))
            ->disabled(true)
            ->canSee($model->exists);
    }


}