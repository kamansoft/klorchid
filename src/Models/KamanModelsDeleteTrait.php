<?php


namespace Kamansoft\Klorchid\Models;


trait KamanModelsDeleteTrait
{
    public function getDeleteValidationRules(?string $field = null): array
    {
        $field = is_null($field) ? 'name' : $field;
        return [
            'element.' . $field => 'required|confirmed'
        ];

    }

}
