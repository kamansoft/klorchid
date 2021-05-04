<?php


namespace Kamansoft\Klorchid\Layouts\Contracts;


interface KlorchidFormsLayoutInterface
{
    static function fullFormInputName(string $attributeName):string;
    public function formFields(): array;
}