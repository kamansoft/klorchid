<?php


namespace Kamansoft\Klorchid\Layouts\Traits;

use Orchid\Screen\Field;
use Orchid\Screen\Fields\Input;

/**
 * Trait BlamingFieldsTrait
 * @package Kamansoft\Klorchid\Layouts\Traits
 * @property \Orchid\Screen\Repository query
 */
trait BlamingFieldsTrait
{


    public function blamingFields($screen_query_model_keyname, $field_class = 'form-control'): array
    {
        return [
            "creator_name"=>$this->creatorNameField($screen_query_model_keyname, $field_class),
            "creation_date"=>$this->createdAtField($screen_query_model_keyname, $field_class),
            "updater_name"=>$this->updaterNameField($screen_query_model_keyname, $field_class),
            "update_date"=>$this->updatedAtField($screen_query_model_keyname, $field_class),
        ];
    }

    public function creatorNameField($screen_query_model_keyname, $field_class = 'form-control'): Field
    {
        return Input::make(implodeWithDot($screen_query_model_keyname, 'creator.name'))
            ->class($field_class)
            ->type('text')
            ->title(__('Created by') . ':')
            ->canSee($this->query->get($screen_query_model_keyname)->exists)
            ->disabled(true);
    }

    public function createdAtField($screen_query_model_keyname, $field_class = 'form-control'): Field
    {

        return Input::make(implodeWithDot($screen_query_model_keyname, 'created_at'))
            ->class($field_class)
            ->type('text')
            ->title(__('Creation date') . ':')
            ->canSee($this->query->get($screen_query_model_keyname)->exists)
            ->disabled(true);
    }

    public function updaterNameField($screen_query_model_keyname, $field_class = 'form-control'): Field
    {
        return Input::make(implodeWithDot($screen_query_model_keyname, 'updater.name'))
            ->class($field_class)
            ->type('text')
            ->title(__('Updated by') . ':')
            ->canSee($this->query->get($screen_query_model_keyname)->exists)
            ->disabled(true);
    }

    public function updatedAtField($screen_query_model_keyname, $field_class = 'form-control'): Field
    {
        return Input::make(implodeWithDot($screen_query_model_keyname, 'updated_at'))
            ->class($field_class)
            ->type('text')
            ->title(__('Update date') . ':')
            ->canSee($this->query->get($screen_query_model_keyname)->exists)
            ->disabled(true);
    }




}