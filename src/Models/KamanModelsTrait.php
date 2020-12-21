<?php


namespace Kamansoft\Klorchid\Models;


use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;


trait KamanModelsTrait
{


    public function getUserToBlameId(): int
    {
        if (Auth::check()) {
            return Auth::user()->id;
        } else {
            return config('klorchid.system_user_id');
        }
    }

    public function blameOnCreate()
    {
        $this->created_by = $this->updated_by = $this->getUserToBlameId();
    }

    public function blameOnUpdate()
    {
        $this->updated_by = $this->getUserToBlameId();
    }


    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {

            $model->blameOnCreate();
            //die('creating model ' .$model->table());

        });

        static::updating(function ($model) {


            $model->blameOnUpdate();

        });



    }


    public function creator()
    {
        return $this->belongsTo('Kamansoft\Klorchid\Models\Kuser', 'created_by', 'id');
    }

    public function updater()
    {
        return $this->belongsTo('Kamansoft\Klorchid\Models\Kuser', 'updated_by', 'id');
    }


    public function getCreatorNameAttribute()
    {
        \Debugbar::info('creator name called');
        return $this->creator->name;
    }

    public function getUpdaterNameAttribute()
    {
        return $this->updater->name;
    }


    public function getMysqlNextAutoincrementalNumber(){
         $next = DB::table('INFORMATION_SCHEMA.TABLES')
            ->select('AUTO_INCREMENT')
            ->where([
                'TABLE_SCHEMA' => config('database.connections.mysql.host'),
                'TABLE_NAME' => $this->getTable()
            ])->first();
        return $next->AUTO_INCREMENT;
    }





}
