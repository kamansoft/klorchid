<?php

namespace Kamansoft\Klorchid\Contracts;

use Illuminate\Database\Eloquent\Model;

interface KlorchidModelRelationLoadbleInterface
{

    public function modelRelations():array;
    public function loadModelRelations(Model $model,array $relations):Model;
    public function setModelWithRelations(Model $model,?array $relations=null );

}