<?php


namespace App\Http\Requests;


use DummyModelFullClassName;

class DummyClass extends \Kamansoft\Klorchid\Http\Request\KlorchidStorableFormRequest
{

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        parent::authorize();
    }

    public function validationRules(): array
    {

        // TODO: Implement validationRules() method.
        return [

        ];
    }

    public function entityRouteParamName(): string
    {
        return 'dummy_param_name';
    }

    /*
    public function statusChange(DummyModelClassName $model): bool
    {
        return parent::statusChange($model);
    }
    */

}
