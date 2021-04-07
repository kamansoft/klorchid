<?php


namespace Kamansoft\Klorchid\Layouts\Contracts;


use Kamansoft\Klorchid\Contracts\KlorchidScreenQueryValidatableInterface;

interface MultiModeScreenLayoutsInterface extends KlorchidScreenQueryValidatableInterface
{

    public function multimodeScreenQueryRequiredKeys():array;
    public function getScreenMode():string;

}