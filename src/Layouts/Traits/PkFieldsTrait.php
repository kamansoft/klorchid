<?php


namespace Kamansoft\Klorchid\Layouts\Traits;


use Orchid\Screen\Field;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Layout;
/**
 * Trait PkFieldsTrait
 * @package Kamansoft\Klorchid\Layouts\Traits
 * @property \Orchid\Screen\Repository query
 *
 */
trait PkFieldsTrait
{
    use KlorchidModelDependantLayoutTrait;
    public function pkField($data_keyname, $field_class = 'form-control'):Field
    {

        $model = $this->getModel();//$this->query->get($data_keyname);

        //$pk_field_name = $model->getKeyName();
        //return Input::make(implodeWithDot($data_keyname, $pk_field_name))
        return Input::make($data_keyname)
            ->type('text')
            ->max(255)
            ->title(__(ucfirst($this->getModel()->getKeyName())))
            ->class($field_class) //. $this->getFieldCssClass($model))
            ->disabled(true)
            ->canSee($model->exists);
    }

}