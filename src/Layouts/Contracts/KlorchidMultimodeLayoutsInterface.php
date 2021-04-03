<?php


namespace Kamansoft\Klorchid\Layouts\Contracts;


interface KlorchidMultimodeLayoutsInterface
{

    public function multimodeScreenQueryRequiredKeys():array;
    public function getScreenMode():string;

}