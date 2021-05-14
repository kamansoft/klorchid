<?php


namespace Kamansoft\Klorchid\Traits;


use Illuminate\Database\Eloquent\Model;

trait KlorchidModeDetectTrait
{

    public function detectMode(Model $model):string{


        return 'default';
    }

}