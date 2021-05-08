<?php


namespace Kamansoft\Klorchid\Layouts\Traits;

use Orchid\Screen\Field;
use Orchid\Screen\Fields\Input;

/**
 * Trait BlamingFields
 * @package Kamansoft\Klorchid\Layouts\Traits
 * @property \Orchid\Screen\Repository query
 */
trait BlamingFields
{


    public function blamingFields($data_keyname, $field_class = 'form-control'): array
    {
        return [
            "creator_name"=>$this->creatorNameField($data_keyname, $field_class),
            "creation_date"=>$this->createdAtField($data_keyname, $field_class),
            "updater_name"=>$this->updaterNameField($data_keyname, $field_class),
            "update_date"=>$this->updatedAtField($data_keyname, $field_class),
        ];
    }

    public function creatorNameField($data_keyname, $field_class = 'form-control'): Field
    {
        return Input::make(implodeWithDot($data_keyname, 'creator.name'))
            ->class($field_class)
            ->type('text')
            ->title(__('Created by') . ':')
            ->canSee($this->query->get($data_keyname)->exists)
            ->disabled(true);
    }

    public function createdAtField($data_keyname, $field_class = 'form-control'): Field
    {

        return Input::make(implodeWithDot($data_keyname, 'created_at'))
            ->class($field_class)
            ->type('text')
            ->title(__('Creation date') . ':')
            ->canSee($this->query->get($data_keyname)->exists)
            ->disabled(true);
    }

    public function updaterNameField($data_keyname, $field_class = 'form-control'): Field
    {
        return Input::make(implodeWithDot($data_keyname, 'updater.name'))
            ->class($field_class)
            ->type('text')
            ->title(__('Updated by') . ':')
            ->canSee($this->query->get($data_keyname)->exists)
            ->disabled(true);
    }

    public function updatedAtField($data_keyname, $field_class = 'form-control'): Field
    {
        return Input::make(implodeWithDot($data_keyname, 'updated_at'))
            ->class($field_class)
            ->type('text')
            ->title(__('Update date') . ':')
            ->canSee($this->query->get($data_keyname)->exists)
            ->disabled(true);
    }




}