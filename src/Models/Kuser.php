<?php

namespace Kamansoft\Klorchid\Models;


use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;


class Kuser extends User
{
    use KamanModelsTrait, KamanModelsDeleteTrait, KamanModelsStatusTrait;


    /**
     * The attributes for which you can use filters in url.
     *
     * @var array
     */
    protected $allowedFilters = [
        'id',
        'name',
        'email',
        'permissions',
        'status'
    ];

    /**
     * The attributes for which can use sort in url.
     *
     * @var array
     */
    protected $allowedSorts = [
        'id',
        'name',
        'email',
        'updated_at',
        'created_at',
        'status'
    ];

    protected $casts = [
        'permissions'          => 'array',
        'email_verified_at'    => 'datetime',
        //'last_login'           => 'datetime',
        //'uses_two_factor_auth' => 'boolean',
        'status'=> 'boolean',
        'cur_status_reason' => 'string',
        //'asigned_pass' => 'boolean',

    ];
    /*protected  $attributes =[
        'uses_two_factor_auth' => False
    ];*/


    public function getEditValidationRules(Request $request){
        return [
            'element.name'=>'required',
            'element.email' => [
                'required',
                Rule::unique($this->getTable(), 'email')->ignore($this)

            ]
        ];
    }

    public function getCreateValidationRules(Request $request){
        return [
            'element.name'=>'required',
            'element.email' => [
                'required',
                Rule::unique($this->getTable(), 'email')->ignore($this)

            ],
            'element.password'=>'required|confirmed'

        ];
    }




}
