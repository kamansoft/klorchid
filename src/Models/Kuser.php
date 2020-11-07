<?php

namespace Kamansoft\Klorchid\Models;


use App\Models\User;


class Kuser extends User
{
    use KamanModelsTrait;

    public static $test = 'foo';
    protected $casts = [
        'permissions'          => 'array',
        'email_verified_at'    => 'datetime',
        //'last_login'           => 'datetime',
        //'uses_two_factor_auth' => 'boolean',
        //'status'=> 'boolean',
        //'cur_status_reason' = 'string',
        //'asigned_pass' => 'boolean',

    ];
    /*protected  $attributes =[
        'uses_two_factor_auth' => False
    ];*/
}
