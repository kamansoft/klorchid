<?php

namespace Kamansoft\Klorchid\Models;

use Illuminate\Database\Eloquent\Model;
use Kamansoft\Klorchid\Models\Contracts\KlorchidEloquentModelInterface;
use Kamansoft\Klorchid\Models\Contracts\KlorchidModelInterface;
use  Kamansoft\Klorchid\Models\Traits\KlorchidModelsTrait;
use  Kamansoft\Klorchid\Models\Traits\KlorchidStatusTrait;


class KlorchidEloquentModel extends Model implements KlorchidModelInterface, KlorchidEloquentModelInterface

{



    use KlorchidModelsTrait;
    use KlorchidStatusTrait;


}