<?php


namespace Kamansoft\Klorchid\Http\Request;


use Kamansoft\Klorchid\Models\KlorchidEloquentModel;
use Kamansoft\Klorchid\Models\KlorchidMultiStatusModel;

class KlorchidStatusChangeFormRequest extends \Illuminate\Foundation\Http\FormRequest
{


    public function authorize()
    {

        return true;
    }


    public function rules():array
    {

        return [

        ];
    }

    public function statusChange(KlorchidMultiStatusModel $model)
    {

    }


}