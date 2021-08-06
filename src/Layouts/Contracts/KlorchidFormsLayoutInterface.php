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

    public static function pkField(KlorchidModelDependantLayoutInterface $form_layout, string $data_keyname,string  $field_class = 'form-control'): Field;


    //blamming fields

    public function blamingFields(string $screen_query_model_keyname,?string $field_class = 'form-control'): array;

    public function creatorNameField(string $screen_query_model_keyname,?string $field_class = 'form-control'): Field;

    public function createdAtField(string $screen_query_model_keyname,?string $field_class = 'form-control'): Field;

    public function updaterNameField(string $screen_query_model_keyname,?string $field_class = 'form-control'): Field;

    public function updatedAtField(string $screen_query_model_keyname,?string $field_class = 'form-control'): Field;


    // status fields

    public function statusFields(string $screen_query_model_keyname, ?string $field_class = null): array;

    public function statusField(string $screen_query_model_keyname, ?string $field_class = null): Field;

    public function statusReasonField(string $screen_query_model_keyname, ?string $field_class = null): Field;

    public function newStatusField(string $screen_query_model_keyname, array $status_options): Field;

    public function newStatusReasonField(string $screen_query_model_keyname): Field;

    public function newStatusFields(string $screen_query_model_keyname, array $status_options): array;
}
