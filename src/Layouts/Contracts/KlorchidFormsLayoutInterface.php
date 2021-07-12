<?php


namespace Kamansoft\Klorchid\Layouts\Contracts;

use Illuminate\Support\Collection;
use Orchid\Screen\Field;

interface KlorchidFormsLayoutInterface
{

    public function formFields(): array;

    public function initFormFields(?array $form_fields = null): self;


    public function setFormFields(Collection $form_fields): self;

    public function fields(): array;

    static function fullFormInputAttributeName(string $attribute_name): string;

    //pkfields

    public static function pkField(KlorchidModelDependantLayoutInterface $form_layout, $data_keyname, $field_class = 'form-control'): Field;


    //blamming fields

    public function blamingFields($screen_query_model_keyname, $field_class = 'form-control'): array;

    public function creatorNameField($screen_query_model_keyname, $field_class = 'form-control'): Field;

    public function createdAtField($screen_query_model_keyname, $field_class = 'form-control'): Field;

    public function updaterNameField($screen_query_model_keyname, $field_class = 'form-control'): Field;

    public function updatedAtField($screen_query_model_keyname, $field_class = 'form-control'): Field;


    // status fields

    public function statusFields($screen_query_model_keyname, ?string $field_class = null): array;

    public function statusField($screen_query_model_keyname, ?string $field_class = null): Field;

    public function statusReasonField($screen_query_model_keyname, ?string $field_class = null): Field;

    public function newStatusField($screen_query_model_keyname, array $status_options): Field;

    public function newStatusReasonField($screen_query_model_keyname): Field;

    public function newStatusFields($screen_query_model_keyname, array $status_options): array;
}
