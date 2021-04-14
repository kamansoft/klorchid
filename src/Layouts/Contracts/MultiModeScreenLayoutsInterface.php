<?php


namespace Kamansoft\Klorchid\Layouts\Contracts;


use Kamansoft\Klorchid\Contracts\KlorchidScreenQueryValidatableInterface;

interface MultiModeScreenLayoutsInterface
{

    public function multiModeScreenQueryRequiredKeys():array;
    public function getScreenMode():string;

}