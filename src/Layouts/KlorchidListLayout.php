<?php


namespace Kamansoft\Klorchid\Layouts;


abstract class KlorchidListLayout extends \Orchid\Screen\Layouts\Table
{


    public $target = null;


    public function __construct()
    {
        $this->target = collection_keyname();
    }



}