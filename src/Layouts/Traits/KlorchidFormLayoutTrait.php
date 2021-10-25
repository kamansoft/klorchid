<?php


namespace Kamansoft\Klorchid\Layouts\Traits;


use Illuminate\Support\Collection;

/**
 * Class KlorchidFormLayoutsTrait
 * @package Kamansoft\Klorchid\Layouts\Traits
 * @method \Kamansoft\Klorchid\Models\KlorchidMultiStatusModel getModel()
 */
trait KlorchidFormLayoutTrait
{

    use KlorchidModelDependantLayoutTrait;
    use PkFieldsTrait;
    use BlamingFieldsTrait;
    use StatusFieldsTrait;

    protected Collection $form_fields;

    private array $common_fields_names = [
        "pk",
        "status_text",
        "status_reason",
        "creator_name",
        "creation_date",
        "updater_name",
        "update_date",
    ];

    public function getFormField(string $field)
    {
        return $this->getFormFields()->get($field);
    }

    public function getFormFields(): Collection
    {
        return $this->form_fields;
    }

    public function setFormFields(Collection $form_fields): self
    {
        $this->form_fields = $form_fields;
        return $this;
    }

    public function fields(): array
    {
        $this->initFormFields();

        //this must be here so some actions can be peforme on $this->form_fields from
        //within the execution of formFIelds method
        //order matter do not change the next lines
        $child_form_fields = $this->formFields();

        $last_fields = $this->form_fields->splice(1);
        $this->setFormFields($this->form_fields->push(...$child_form_fields)->concat($last_fields));


        return $this->form_fields->toArray();
    }

    public function initFormFields(?array $form_fields = null): self
    {
        //dd($this->statusFields(self::$screen_query_model_keyname,$this->getModel()->statusPresenter()->getStatusFieldColorClass()));
        if (is_null($form_fields)) {

            $form_fields = array_merge(
                [
                    'pk' => self::pkField(
                        $this,
                        $this->fullFormInputAttributeName(
                            $this->getModel()->getKeyName()
                        ),
                        'form-control text-dark'
                    )
                ],
                //$this->newStatusFields(self::$screen_query_model_keyname,$this->getModel()->statusPresenter()->getOptions()),
                $this->statusFields(self::$screen_query_model_keyname),
                $this->blamingFields(self::$screen_query_model_keyname, 'form-control text-dark')
            );

        }


        if (!isset($this->form_fields)) {
            $this->setFormFields(collect($form_fields));
        }
        return $this;
    }


    public function loopFormFields($function){
        $this->form_fields->map(function ($field,$key)use($function){
            $function($field,$key);
        });
        return $this;
    }

    public function loopCommonFields($function){
        $this->loopFormFields(function ($field,$key)use ($function){
            if (in_array($key,$this->common_fields_names)){
                $function($field,$key);
            }
        });
        return $this;
    }

    public function hideCommonFields(){
        $this->loopCommonFields(function ($field,$key){
            $field->canSee(false);
        });
    }


    static function fullFormInputAttributeName(string $attribute_name): string
    {

        return implodeWithDot(self::$screen_query_model_keyname, $attribute_name);
    }


}