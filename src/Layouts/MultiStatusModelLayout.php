<?php


namespace Kamansoft\Klorchid\Layouts;


use Kamansoft\Klorchid\Layouts\Contracts\MultiModeScreenLayoutsInterface;
use Kamansoft\Klorchid\Layouts\Contracts\MultiStatusModelLayoutInterface;
use Kamansoft\Klorchid\Layouts\Contracts\ScreenQueryDataBasedLayoutInterface;
use Kamansoft\Klorchid\Layouts\Traits\MultiStatusModelLayoutTrait;
use Kamansoft\Klorchid\Layouts\Traits\ScreenQueryDataBasedLayoutTrait;
use Orchid\Screen\Field;

abstract class MultiStatusModelLayout extends KlorchidLayout implements ScreenQueryDataBasedLayoutInterface, MultiStatusModelLayoutInterface
{
    use ScreenQueryDataBasedLayoutTrait;
    use MultiStatusModelLayoutTrait;


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