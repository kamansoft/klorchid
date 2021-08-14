<?php

namespace Kamansoft\Klorchid\Models;

//use Datakrama\Eloquid\Traits\Uuids;
use Illuminate\Database\Eloquent\Model;
use Kamansoft\Klorchid\Models\Contracts\KlorchidModelsInterface;
use Kamansoft\Klorchid\Models\Contracts\KlorchidUserBlamingModelInterface;
use Kamansoft\Klorchid\Models\Contracts\PkPresentableInterface;
use  Kamansoft\Klorchid\Models\Traits\KlorchidUserBlamingModelsTrait;
use Kamansoft\Klorchid\Models\Traits\KlorchidEloquentModelsTrait;
use Kamansoft\Klorchid\Models\Traits\PkPresentableTrait;


class KlorchidEloquentModel extends Model implements KlorchidModelsInterface, KlorchidUserBlamingModelInterface, PkPresentableInterface

{
    use KlorchidUserBlamingModelsTrait;
    use KlorchidEloquentModelsTrait;
    use PkPresentableTrait;
    //use Uuids;

}