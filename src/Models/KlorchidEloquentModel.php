<?php


namespace Kamansoft\Klorchid\Models;

use Illuminate\Database\Eloquent\Model;
use Kamansoft\Klorchid\Models\Contracts\KlorchidEloquentModelInterface;
use Kamansoft\Klorchid\Models\Contracts\KlorchidModelInterface;
use Illuminate\Support\Facades\Auth;

class KlorchidEloquentModel extends Model implements KlorchidModelInterface, KlorchidEloquentModelInterface

{

    public function getUserToBlameId(): string
    {
        $to_return = '';
        if (Auth::check()) {
            $to_return = Auth::user()->id;
        } else {
            $to_return = config('klorchid.system_user_id');
        }
        return $to_return;
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
        //\DeBugbaR::info('creator name called');
        return $this->creator->name;
    }

    public function getUpdaterNameAttribute()
    {
        return $this->updater->name;
    }

    public function refreshFromDb()
    {
        $element = self::findOrFail($this->getKey());
        $this->fill($element->toArray());
    }
}