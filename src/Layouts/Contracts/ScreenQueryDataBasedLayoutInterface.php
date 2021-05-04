<?php


namespace Kamansoft\Klorchid\Layouts\Contracts;


use Kamansoft\Klorchid\Models\Contracts\KlorchidModelsInterface;

interface ScreenQueryDataBasedLayoutInterface
{



    public function getData();

    public function getScreenFormDataKeyname();


}