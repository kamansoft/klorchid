<?php

use Orchid\Screen\Field;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\TextArea;


trait KlorchidFormLayoutsTrait
{

    public function getPkField(): Field
    {
        $model = $this->getModel();
        $pk_field_name = $model->getKeyName();
        $field_class = $this->klorchidFieldStatusClass();

        return Input::make($this->prefixFormDataKeyTo($pk_field_name))
            ->type('text')
            ->max(255)
            ->title(__(ucfirst($pk_field_name)))
            ->class($field_class) //. $this->getFieldCssClass($model))
            ->disabled(true)
            ->canSee($model->exists());
    }

    public function klorchidFieldStatusClass(string $extra = 'form-control ', ?object $element = null)
    {
        $element = $element ?? $this->getModel();
        if ($this->fieldIsDisabled($element)) {
            $to_return = 'text-danger';
        } else {
            $to_return = 'text-success';
        }
        $to_return = $to_return . ' ' . $extra;

        return $to_return;
    }

    public function fieldIsDisabled(?object $element = null): bool
    {
        $element = $element ?? $this->getModel();
        $to_return = false;
        if (property_exists($element, 'status')) {
            $to_return = !boolval($element->status);
        }
        return $to_return;
    }

    public function getStatusFields(): array
    {
        return [
            $this->getStatusField(),
            $this->getStatusReasonField(),
        ];
    }

    public function getStatusField(): Field
    {
        $field_class = $this->klorchidFieldStatusClass();
        return Input::make($this->prefixFormDataKeyTo('stringStatus'))
            ->class($field_class) //. $this->getFieldCssClass($model))
            ->type('text')
            ->title(__('Current Status') . ':')
            ->disabled(true);
    }

    public function getStatusReasonField(): Field
    {
        $field_class = $this->klorchidFieldClass();
        return TextArea::make($this->prefixFormDataKeyTo('cur_status_reason'))
            ->class($field_class)
            ->title(__('Current Status Reason') . ': ')
            ->disabled(true);
    }

    public function getBlamingFields(): array
    {
        $field_class = $this->klorchidFieldClass();
        return [
            Input::make($this->prefixFormDataKeyTo('creatorName'))
                ->class($field_class)
                ->type('text')
                ->title(__('Created by') . ':')
                ->disabled(true),
            Input::make($this->prefixFormDataKeyTo('created_at'))
                ->class($field_class)
                ->type('text')
                ->title(__('Creation date') . ':')
                ->disabled(true),
            Input::make(config('klorchid.screen_query_required_elements.element_to_display') . '.updaterName')
                ->class($field_class)
                ->type('text')
                ->title(__('Updated by') . ':')
                ->disabled(true),
            Input::make(config('klorchid.screen_query_required_elements.element_to_display') . '.updated_at')
                ->class($field_class)
                ->type('text')
                ->title(__('Update date') . ':')
                ->disabled(true),

        ];
    }
}