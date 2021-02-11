<?php


namespace Kamansoft\Klorchid\Models\Traits;


trait KlorchidEloquentModelsTrait
{

    public function creator()
    {
        return $this->belongsTo(self::userModelClass(), 'created_by', 'id');
    }

    public function updater()
    {
        return $this->belongsTo(self::userModelClass(), 'updated_by', 'id');
    }

}