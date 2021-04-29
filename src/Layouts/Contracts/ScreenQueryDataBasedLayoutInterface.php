<?php


namespace Kamansoft\Klorchid\Layouts\Contracts;


interface ScreenQueryDataBasedLayoutInterface
{
    static function fullFormInputName(string $attributeName):string;

    public function getData();

    public function getScreenFormDataKeyname();


}