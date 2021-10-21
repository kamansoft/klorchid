<?php


namespace Kamansoft\Klorchid\Http\Request;


use Illuminate\Database\Eloquent\Model;
use Kamansoft\Klorchid\Models\KlorchidMultiStatusModel;
use function PHPUnit\Framework\isType;

abstract class EntityDependantFormRequest extends \Illuminate\Foundation\Http\FormRequest
{
    //abstract public function entityRouteParamName():string;
    abstract public function entityRouteParamName():string;


    /**
     * @return \Illuminate\Routing\Route|object|string|null|KlorchidMultiStatusModel
     */
    public function getModel()
    {

        //TODO: this must be improoved
        //if there is a TypeError there must be a wrong binding needed for a request to work
        return $this->route($this->entityRouteParamName());

    }


}