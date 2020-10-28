<?php

declare(strict_types=1);

namespace Kamansoft\Klorchid\Models;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;

/**
 * Trait whoWasTrait.
 */
trait WhoWasTrait
{
    public static $values =  [
        'active' => 1,
        'inactive' => 0

    ];

    /**
     * The valid class@method or commads that are able to
     * register a new user with very same self being created user as its own creator or updater
     *
     * @var array
     */
    public static  $validSelfCreateUserActions = [
        'orchid:admin',
        'RegisterController@register'
    ];


    public function hasTrait(){
        return true;
    }
    private static function getAction(){
        //Determinate if request comes from console
        if(app()->runningInConsole()){
            return $_SERVER['argv'][1];
        }else{
            $current_action = explode(
                "\\",
                Route::currentRouteAction()
            );
            return end(
                $current_action
            );
        }
    }

    /**
     * Boot function for using with User Events
     *
     * @return void
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
           // $self_creating =    in_array(self::getAction(),self::$validSelfCreateUserActions);

            if (in_array(self::getAction(),self::$validSelfCreateUserActions)) {
                DB::beginTransaction();
                $model->id = $model::getAutoIncrement();
                $model->created_by = $model->updated_by = $model::getAutoIncrement();
            }else{
                $model->created_by = $model->updated_by = Auth::user()->id;
                $model->updated_by = Auth::user()->id;
            }
        });

        static::updating(function ($model) {
            if (in_array(self::getAction(),self::$validSelfCreateUserActions)) {
                DB::beginTransaction();
                $model->updated_by = Auth::user()->id;
            }
        });

        static::updated(function ($model) {
            if (in_array(self::getAction(),self::$validSelfCreateUserActions)) {
                DB::commit();
            }
        });

        static::created(function ($model) {
            if (in_array(self::getAction(),self::$validSelfCreateUserActions)) {
                DB::commit();
            }
        });
    }

    public static function getAutoIncrement() {

        $next=DB::table('INFORMATION_SCHEMA.TABLES')
            ->select('AUTO_INCREMENT')
            ->where([
                'TABLE_SCHEMA'=>'Kaman',
                'TABLE_NAME'=>'users'
               ])->first();
        return $next->AUTO_INCREMENT;
    }
    public function getStringStatusAttribute()
    {

        return __($this::statusToString($this->status > 0));
    }



    public static function statusToString(bool $status)
    {
        return array_search($status, self::$values);
    }

    public static function stringToStatus(string $status)
    {
        return self::$values[$status];
    }




    public function creator(){
        return $this->belongsTo('App\User', 'created_by', 'id');
    }

    public function updater(){
        return $this->belongsTo('App\User', 'updated_by', 'id');
    }



    public function getCreatorNameAttribute(){
        return $this->creator->name;
    }

    public function getUpdaterNameAttribute(){
        return $this->updater->name;
    }
    /*
        public function getCreatedAtAttribute($date)
        {
            return Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $date)->format('Y-m-d');
        }
        public function getUpdatedAtAttribute($date)
        {
            return Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $date)->format('Y-m-d');
        }
        */
}
