<?php

namespace Kamansoft\Klorchid\Models;

//use Datakrama\Eloquid\Traits\Uuids;
use Illuminate\Database\Eloquent\Model;
use Kamansoft\Klorchid\Models\Contracts\KlorchidModelsInterface;
use Kamansoft\Klorchid\Models\Contracts\KlorchidUserBlamingModelInterface;
use  Kamansoft\Klorchid\Models\Traits\KlorchidUserBlamingModelsTrait;
use Kamansoft\Klorchid\Models\Traits\KlorchidEloquentModelsTrait;


class KlorchidEloquentModel extends Model implements KlorchidModelsInterface, KlorchidUserBlamingModelInterface

{
    use KlorchidUserBlamingModelsTrait;
    use KlorchidEloquentModelsTrait;
    //use Uuids;

}