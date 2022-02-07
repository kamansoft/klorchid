<?php


namespace Kamansoft\Klorchid\Http\Request;


use Illuminate\Support\Facades\Log;
use Kamansoft\Klorchid\Contracts\KlorchidModelRelationLoadbleInterface;
use Kamansoft\Klorchid\Models\KlorchidMultiStatusModel;
use Kamansoft\Klorchid\Traits\KlorchidModelRelationLoadbleTrait;

abstract class EntityDependantFormRequest extends \Illuminate\Foundation\Http\FormRequest implements KlorchidModelRelationLoadbleInterface
{
    use KlorchidModelRelationLoadbleTrait;
    //abstract public function entityRouteParamName():string;
    abstract public function entityRouteParamName(): string;
 


    /**
     * return if exists the model binded in laravel route model
     *
     * @return null|KlorchidMultiStatusModel
     */
    public function getModelFromRoute()
    {

        //TODO: this must be improoved
        //if there is a TypeError there must be a wrong binding needed for a request to work
        //return $this->route($this->entityRouteParamName());
        $param_key=$this->entityRouteParamName();
        if (array_key_exists($param_key, $this->route()->parameters())) {
            return $this->route()->parameters()[$param_key];
            //return $this->loadModelRelations($this->route()->parameters()[$param_key]);
        }

        return null ;


    }
    abstract public function modelRelations():array;


}