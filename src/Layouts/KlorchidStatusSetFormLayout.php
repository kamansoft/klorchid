<?php


namespace Kamansoft\Klorchid\Layouts;


use Kamansoft\Klorchid\Layouts\Contracts\MultiStatusModelLayoutInterface;
use Kamansoft\Klorchid\Layouts\Contracts\ScreenQueryDataBasedLayoutInterface;
use Kamansoft\Klorchid\Layouts\Traits\MultiStatusModelLayoutTrait;
use Kamansoft\Klorchid\Layouts\Traits\StatusFieldsTrait;

class KlorchidStatusSetFormLayout extends KlorchidBasicLayout implements  MultiStatusModelLayoutInterface
{
    use MultiStatusModelLayoutTrait;
    use StatusFieldsTrait;

    public function fields():array
    {
        $current_status_fields=$this->statusFields($this->getScreenQueryModelKeyname());
        $new_status_fields=$this->newStatusField($this->getScreenQueryModelKeyname(),$this->getModel());
        return ;
    }
}