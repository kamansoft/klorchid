<?php


namespace Kamansoft\Klorchid\Models\Presenters;

use Illuminate\Support\Str;

/**
 * Class MultiStatusModelPresenter
 * @package Kamansoft\Klorchid\Models\Presenters
 * @method
 */
class MultiStatusModelPresenter extends \Orchid\Support\Presenter
{


    /**
     * returns an array of a key pared elements value=>Presentation Name
     * @return mixed
     */
    public function options()
    {
         return collect(array_flip($this->entity::statusValues()))->mapWithKeys(function($value,$name){
               return [$value=>Str::ucfirst(__($name))];
         })->toArray();
    }




}