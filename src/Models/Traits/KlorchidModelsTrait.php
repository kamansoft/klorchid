<?php


namespace Kamansoft\Klorchid\Models\Traits;


use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Kamansoft\Klorchid\Models\Kuser;


trait KlorchidModelsTrait
{


	protected static function boot() {
		parent::boot();
		static::creating(function ($model) {
			$model->blameOnCreate();
		});
		static::updating(function ($model) {
			$model->blameOnUpdate();

		});
	}


	public function refreshFromDb() {
		$element = self::findOrFail($this->getKey());
		$this->fill($element->toArray());
	}


	static public function userModelClass():string
	{
		return Kuser::class;
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



	public function getCreatorNameAttribute() {

		return $this->creator->name ?? '';
	}

	public function getUpdaterNameAttribute() {
		return $this->updater->name ?? '';
	}


}
