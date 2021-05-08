<?php


namespace Kamansoft\Klorchid\Layouts\Traits;


use Orchid\Screen\Fields\Input;
use Orchid\Screen\Layout;
/**
 * Trait PkFields
 * @package Kamansoft\Klorchid\Layouts\Traits
 * @property \Orchid\Screen\Repository query
 *
 */
trait PkFields
{
    public function pkField($data_keyname, $field_class = 'form-control'): Field
    {

        $model = $this->query->get($data_keyname);

        $pk_field_name = $model->getKeyName();

        return Input::make(implodeWithDot($data_keyname, $pk_field_name))
            ->type('text')
            ->max(255)
            ->title(__(ucfirst($pk_field_name)))
            ->class($field_class) //. $this->getFieldCssClass($model))
            ->disabled(true)
            ->canSee($model->exists);
    }

}