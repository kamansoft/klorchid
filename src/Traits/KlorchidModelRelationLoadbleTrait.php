<?php

namespace Kamansoft\Klorchid\Traits;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;

trait KlorchidModelRelationLoadbleTrait
{

    public function loadModelRelations(Model $model,array $relations):Model
    {

        collect($relations)->map(function ($item, $key) use ($model) {
            if (is_array($item)) {
                $model->load($key);
                if (is_null($model->$key)) {
                    Log::info(static::class . ' there is no related key value to load ' . $key . ' relation on model');
                } else {
                    $this->loadModelRelations($model->$key, $item);
                }
            } else {
                $model->load($item);
            }
        });

        return $model;
    }

    public function setModelWithRelations(Model $model,?array $relations=null ){
        if ($model->exists) {
            $relations = $relations ?? $this->modelRelations();
            $this->loadModelRelations($model, $relations);
        }
        return $this->setModel($model);

    }

}