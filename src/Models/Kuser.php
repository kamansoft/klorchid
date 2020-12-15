<?php

namespace Kamansoft\Klorchid\Models;


use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Laravel\Jetstream\HasProfilePhoto;
use Laravel\Sanctum\HasApiTokens;
use Orchid\Attachment\Attachable;
use Orchid\Attachment\Models\Attachment;


class Kuser extends User
{
    use KamanModelsTrait, KamanModelsDeleteTrait, KamanModelsStatusTrait;
    use HasApiTokens;
    use HasFactory;
    //use HasProfilePhoto;
    use Notifiable;
    use TwoFactorAuthenticatable;
    use Attachable;

     /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'permissions',
        'kavatar'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
        'permissions',
        'two_factor_recovery_codes',
        'two_factor_secret',
    ];



    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = [
        'profile_photo_url',
        'kavatar'
    ];

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


    public function kavatar(){
        return $this->hasOne(Attachment::class, 'id', 'kavatar')->withDefault();
    }




}