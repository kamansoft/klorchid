<?php

namespace Kamansoft\Klorchid\Traits;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;

trait KlorchidModelRelationLoadbleTrait
{




    /**
     * @param Model $model
     * @param  array|string  $relations
     * @return Model
     */
    public function loadModelRelations(Model $model,?array $relations=null ):Model
    {
        $relations = $relations ?? $this->modelRelations();
        return $model->load($relations);
    }



    public function setModelWithRelations(Model $model,?array $relations=null ){
        if ($model->exists) {

            $this->loadModelRelations($model, $relations);
        }
        return $this->setModel($model);

    }

}