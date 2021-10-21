<?php

namespace Kamansoft\Klorchid\Screens\Contracts;

use Kamansoft\Klorchid\Models\KlorchidEloquentModel;

interface KlorchidModelDependantScreenInterface
{

    public function getModel(): KlorchidEloquentModel;

    public function setModel(KlorchidEloquentModel $model): self;

}