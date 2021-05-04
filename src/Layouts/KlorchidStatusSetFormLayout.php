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
        $current_status_fields=$this->getStatusFields($this->getScreenFormDataKeyname());
        $new_status_fields=$this->getNewStatusField($this->getScreenFormDataKeyname(),$this->getData());
        return ;
    }
}