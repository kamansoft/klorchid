<?php


namespace Kamansoft\Klorchid\Layouts\Contracts;


use Kamansoft\Klorchid\Models\Contracts\KlorchidModelsInterface;

interface ScreenQueryDataBasedLayoutInterface
{



    public function getModel();

    public function getScreenQueryModelKeyname();


}