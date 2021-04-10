<?php


namespace Kamansoft\Klorchid\Layouts;


use Kamansoft\Klorchid\Layouts\Traits\MultiStatusModeLayoutTrait;
use Orchid\Screen\Field;

abstract class MultiStatusLayout extends KlorchidLayout
{

    use MultiStatusModeLayoutTrait;


    public function statusClassKernels(){
        return [
            'active' => 'text-dark',
            'inactive' => ''
        ];
    }

    public function __construct()
    {
        parent::__construct();
        $this->setStatusClassKernels();
    }

}