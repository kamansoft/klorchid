<?php


namespace Kamansoft\Klorchid\Http\Request;


use Illuminate\Support\Facades\Log;
use Kamansoft\Klorchid\Models\KlorchidMultiStatusModel;

abstract class EntityDependantFormRequest extends \Illuminate\Foundation\Http\FormRequest
{
    //abstract public function entityRouteParamName():string;
    abstract public function entityRouteParamName(): string;


    /**
     * @return \Illuminate\Routing\Route|object|string|null|KlorchidMultiStatusModel
     */
    public function getModel()
    {

        //TODO: this must be improoved
        //if there is a TypeError there must be a wrong binding needed for a request to work
        //return $this->route($this->entityRouteParamName());
        $param_key='model';
        $class_attribute_name_form_model_class = 'model_class';
        if (array_key_exists($param_key, $this->route()->parameters())) {
            return $this->route()->parameters()[$param_key];
        }

        if(property_exists($this, $class_attribute_name_form_model_class)){
            return new $this->model_class;
        }

        $message = ' Cant get a Model class to bind with this request object.  The "'.$param_key.'" route param value was not found and the attribute "'.$class_attribute_name_form_model_class.'" for '.static::class.' is missing. You can add the '.$param_key.' to the class';
        Log::error($message);
        throw new \Exception($message);
    }


}