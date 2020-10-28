<?php


namespace Kamansoft\Klorchid\Layouts;


use Orchid\Screen\Layouts\Rows;
use Orchid\Screen\Fields\Input;

abstract class KamanRows extends Rows
{

    public function statusClass (bool $status):string{
        return $status ? 'text-success' : 'text-danger';
    }




}
