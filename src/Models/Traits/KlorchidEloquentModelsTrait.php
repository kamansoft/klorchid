<?php


namespace Kamansoft\Klorchid\Models\Traits;


use Kamansoft\Klorchid\Models\KlorchidUserModel;


trait KlorchidEloquentModelsTrait
{



    protected static function bootKlorchidEloquentModelsTrait() {

		static::creating(function ($model) {
			$model->blameOnCreate();
		});
		static::updating(function ($model) {
			$model->blameOnUpdate();
		});
	}




	static public function userModelClass():string
	{
		return KlorchidUserModel::class;
	}

    public function creator()
    {

        return $this->belongsTo(self::userModelClass(), 'created_by', 'id');
    }

    public function updater()
    {
        return $this->belongsTo(self::userModelClass(), 'updated_by', 'id');
    }

}