<?php


namespace Kamansoft\Klorchid\Layouts;


use Illuminate\Support\Str;
use Kamansoft\Klorchid\Layouts\Traits\CommonFieldsTrait;
use Kamansoft\Klorchid\Layouts\Traits\StatusFieldsTrait;
use Orchid\Screen\Field;

abstract class KlorchidFormLayout extends KlorchidLayout
{
    use CommonFieldsTrait;
    use StatusFieldsTrait;

    private bool $enabled_pk_field = true;
    private bool $enabled_blaming_fields = true;
    private bool $enabled_status_fields = true;

    /**
     * @return bool
     */
    public function isEnabledPkField(): bool
    {
        return $this->enabled_pk_field;
    }

    /**
     * @param bool $enabled_pk_field
     * @return KlorchidFormLayout
     */
    public function setEnabledPkField(bool $enabled_pk_field): KlorchidFormLayout
    {
        $this->enabled_pk_field = $enabled_pk_field;
        return $this;
    }

    /**
     * @return bool
     */
    public function isEnabledBlamingFields(): bool
    {
        return $this->enabled_blaming_fields;
    }

    /**
     * @param bool $enabled_blaming_fields
     * @return KlorchidFormLayout
     */
    public function setEnabledBlamingFields(bool $enabled_blaming_fields): KlorchidFormLayout
    {
        $this->enabled_blaming_fields = $enabled_blaming_fields;
        return $this;
    }

    /**
     * @return bool
     */
    public function isEnabledStatusFields(): bool
    {
        return $this->enabled_status_fields;
    }

    /**
     * @param bool $enabled_status_fields
     * @return KlorchidFormLayout
     */
    public function setEnabledStatusFields(bool $enabled_status_fields): KlorchidFormLayout
    {
        $this->enabled_status_fields = $enabled_status_fields;
        return $this;
    }




    /**
     * @inheritDoc
     */
    protected function fields(): array
    {
        $fields = [];

        if ($this->isEnabledPkField()) {
            $fields[] = $this->getPkField($this->getScreenQueryDataKeyname(), 'form-control text-dark');
        }

        $fields = array_merge($fields, $this->formFields());

        if ($this->isEnabledStatusFields()) {
            $fields = array_merge($fields, $this->getStatusFields($this->getScreenQueryDataKeyname(), 'form-control'));
        }
        if ($this->isEnabledBlamingFields()) {
            $fields = array_merge($fields, $this->getBlamingFields($this->getScreenQueryDataKeyname(), 'form-control'));
        }

        \Debugbar::debug($fields);

        return $fields;
    }

    abstract function formFields(): array;
}