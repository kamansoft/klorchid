<?php

namespace Kamansoft\Klorchid\Models;


use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Http\Request;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Kamansoft\Klorchid\Models\Contracts\BooleanStatusModelInterface;
use Kamansoft\Klorchid\Models\Contracts\KlorchidModelsInterface;
use Kamansoft\Klorchid\Models\Contracts\KlorchidMultiStatusModelInterface;
use Kamansoft\Klorchid\Models\Traits\BooleanStatusModelTrait;
use Kamansoft\Klorchid\Models\Traits\KlorchidModelsExtraCastTrait;
use Kamansoft\Klorchid\Models\Traits\KlorchidMultiStatusModelTrait;
use Kamansoft\Klorchid\Models\Traits\KlorchidUserBlamingModelsTrait;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Laravel\Sanctum\HasApiTokens;
use Orchid\Attachment\Attachable;
use Orchid\Attachment\Models\Attachment;


class KlorchidUser extends User implements KlorchidModelsInterface,
    KlorchidMultiStatusModelInterface, BooleanStatusModelInterface
{

    use HasApiTokens;
    use HasFactory;

    //use HasProfilePhoto;
    use Notifiable;
    use TwoFactorAuthenticatable;
    use Attachable;

    //klorchid related
    use KlorchidModelsExtraCastTrait;
    use KlorchidUserBlamingModelsTrait;
    use KlorchidMultiStatusModelTrait;
    use BooleanStatusModelTrait;

    protected $table = 'users';
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
        //'profile_photo_url',
        //'kavatar'
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
        'permissions' => 'array',
        'email_verified_at' => 'datetime',
        //'last_login'           => 'datetime',
        //'uses_two_factor_auth' => 'boolean',
        'status' => 'boolean',
        'cur_status_reason' => 'string',
        //'asigned_pass' => 'boolean',

        'updated_at' => 'datetime:d/m/Y h:m:s a',
        'created_at' => 'datetime:d/m/Y h:m:s a',
    ];



    /*protected  $attributes =[
        'uses_two_factor_auth' => False
    ];*/

    public function getEditValidationRules(Request $request): array
    {

        return [
            'element.name' => 'required',
            'element.email' => [
                'required',
                Rule::unique($this->getTable(), 'email')->ignore($this)

            ]
        ];
    }

    public function getCreateValidationRules(Request $request): array
    {
        return [
            'element.name' => 'required',
            'element.email' => [
                'required',
                Rule::unique($this->getTable(), 'email')->ignore($this)

            ],
            'element.password' => 'required|confirmed'

        ];
    }


    public function kavatar()
    {
        return $this->hasOne(Attachment::class, 'id', 'kavatar')->withDefault();
    }


    public function delete(): bool
    {

        $to_return = false;
        $isSoftDeleted = array_key_exists(SoftDeletes::class, class_uses($this));
        //\DeBugbaR::info('system user id '.config('klorchid.system_user_id'));
        try {


            if ($this->exists && !$isSoftDeleted) {


                DB::beginTransaction();

                //check if the user to be deleted is self referencend on updated_by or created_by and change by system user
                if ($this->updated_by == $this->id) {
                    DB::update('update users set  `email_verified_at` = NULL, `updated_by` = ' . config('klorchid.system_user_id') . ' where id = ?', [$this->id]);

                }
                if ($this->created_by == $this->id) {

                    DB::update('update users set created_by = ' . config('klorchid.system_user_id') . ' where id = ?', [$this->id]);
                    die('here created');
                }
                $to_return = parent::delete(); // TODO: Change the autogenerated stub

                DB::commit();
            } else {
                $to_return = parent::delete();
            }
        } catch (\Exception $e) {
            throw new \Exception('cant delete user its referencing to itself, ' . $e->getMessage());

        }

        return $to_return;


    }


}
