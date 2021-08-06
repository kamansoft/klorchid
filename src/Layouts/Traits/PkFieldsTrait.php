<?php


namespace Kamansoft\Klorchid\Layouts\Traits;


use Kamansoft\Klorchid\Layouts\Traits\KlorchidModelDependantLayoutTrait;
use Orchid\Screen\Field;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Layout;
use Kamansoft\Klorchid\Layouts\Contracts\KlorchidModelDependantLayoutInterface;

/**
 * Trait PkFieldsTrait
 * @package Kamansoft\Klorchid\Layouts\Traits
 * @property \Orchid\Screen\Repository query
 *
 */
trait PkFieldsTrait
{
    use KlorchidModelDependantLayoutTrait;
    /*
    public function pkField($data_keyname, $field_class = 'form-control'): Field
    {

        $model = $this->getModel(); //$this->query->get($data_keyname);

        //$pk_field_name = $model->getKeyName();
        //return Input::make(implodeWithDot($data_keyname, $pk_field_name))
        return Input::make($data_keyname)
            ->type('text')
            ->max(255)
            ->title(__(ucfirst($this->getModel()->getKeyName())))
            ->class($field_class) //. $this->getFieldCssClass($model))
            ->disabled(true)
            ->canSee($model->exists);
    }*/

    /**
     *
     * Returns a well formed id field for klorchid apps
     *
     * @param KlorchidModelDependantLayoutInterface $form_layout the layout instance
     * @param string $data_keyname the html form input keyname
     * @param string $field_class
     * @return Field
     */
    public static function pkField(
        KlorchidModelDependantLayoutInterface $form_layout,
        string $data_keyname,string $field_class = 'form-control'): Field
    {
        $model = $form_layout->getModel();
        return Input::make($data_keyname)
            ->type('text')
            ->max(255)
            ->title(__(ucfirst($model->getKeyName())))
            ->class($field_class) //. $this->getFieldCssClass($model))
            ->disabled(true)
            ->canSee($model->exists);
    }
}
