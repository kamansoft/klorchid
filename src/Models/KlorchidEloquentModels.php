<?php

namespace Kamansoft\Klorchid\Models;

use Datakrama\Eloquid\Traits\Uuids;
use Illuminate\Database\Eloquent\Model;
use Kamansoft\Klorchid\Models\Contracts\KlorchidModelsInterface;
use  Kamansoft\Klorchid\Models\Traits\KlorchidUserBlamingModelsTrait;
use  Kamansoft\Klorchid\Models\Traits\KlorchidModelsStatusTrait;
use Kamansoft\Klorchid\Models\Traits\KlorchidEloquentModelsTrait;


class KlorchidEloquentModels extends Model implements KlorchidModelsInterface

{



    use KlorchidUserBlamingModelsTrait;
    use KlorchidModelsStatusTrait;
    use KlorchidEloquentModelsTrait;
    use Uuids;


}