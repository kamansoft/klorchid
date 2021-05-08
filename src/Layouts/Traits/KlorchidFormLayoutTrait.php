<?php


namespace Kamansoft\Klorchid\Layouts\Traits;


use Illuminate\Support\Collection;

/**
 * Class KlorchidFormLayoutsTrait
 * @package Kamansoft\Klorchid\Layouts\Traits
 * @method \Kamansoft\Klorchid\Models\KlorchidEloquentModel getModel()
 */
trait KlorchidFormLayoutTrait
{

    use KlorchidModelDependantLayoutTrait;
    use PkFields;
    use BlamingFields;

    protected Collection $form_fields;

    public function initFormFields(?array $form_fields = null): KlorchidFormLayoutTrait
    {

        if (is_null($form_fields)) {
            $form_fields = array_merge(
                ['pk' => $this->pkField($this->fullFormInputAttributeName($this->getModel()->getKeyName()))],
                $this->blamingFields($this->fullFormInputAttributeName($this->getModel()->getKeyName()))
            );

        }

        if (!isset($this->form_fields)) {
            $this->setFormFields(collect($form_fields));
        }
        return $this;
    }


    public function setFormFields(Collection $form_fields): KlorchidFormLayoutTrait
    {
        $this->form_fields = $form_fields;
        return $this;
    }

    public function fields(): array
    {
        //$this->initFormFields();

        //this must be here so some actions can be peforme on $this->form_fields from
        //within the execution of formFIelds method
        //order matter do not change the next lines
        //$child_form_fields = $this->formFields();
        //$first_field=$this->form_fields->splice(1);
        //$this->form_fields->prepend($child_form_fields)->prepend($first_field);
        //do not change execution of above statements

        return [];
    }

    static function fullFormInputAttributeName(string $attribute_name): string
    {

        return implodeWithDot(self::$screen_query_model_keyname, $attribute_name);
    }


}