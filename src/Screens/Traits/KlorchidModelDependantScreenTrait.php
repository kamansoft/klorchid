<?php

namespace Kamansoft\Klorchid\Screens\Traits;

use Illuminate\Database\Eloquent\Model;
use Kamansoft\Klorchid\Models\KlorchidEloquentModel;

trait KlorchidModelDependantScreenTrait
{

    public function getModel(): KlorchidEloquentModel
    {
        return $this->model;
    }


    public function setModel(KlorchidEloquentModel $model): self
    {

        $this->model = $model;
        return $this;
    }
}