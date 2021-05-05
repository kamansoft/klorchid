<?php


namespace Kamansoft\Klorchid\Models\Traits;


use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Kamansoft\Klorchid\Models\KlorchidUser;


trait KlorchidUserBlamingModelsTrait
{



    protected static function bootKlorchidEloquentModelsTrait() {

		static::creating(function ($model) {
			$model->blameOnCreate();
		});
		static::updating(function ($model) {
			$model->blameOnUpdate();
		});
	}


	public function getUserToBlameId(): string{
		$to_return = '';
		if (Auth::check()) {
			$to_return = Auth::user()->id;
		} else {
			$to_return = config('klorchid.system_user_id');
		}
		return $to_return;
	}

	public function blameOnCreate() {
		$this->created_by = $this->updated_by = $this->getUserToBlameId();
	}

	public function blameOnUpdate() {
		$this->updated_by = $this->getUserToBlameId();
	}



	static public function userModelClass(): string
    {
        return KlorchidUser::class;
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(self::userModelClass(), config('klorchid.models_common_field_names.creator'), 'id');
    }

    public function updater(): BelongsTo
    {
        return $this->belongsTo(self::userModelClass(),config('klorchid.models_common_field_names.last_updater'), 'id');
    }


}
