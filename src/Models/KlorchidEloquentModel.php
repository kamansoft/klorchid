<?php

namespace Kamansoft\Klorchid\Models;

use Illuminate\Database\Eloquent\Model;
use Kamansoft\Klorchid\Models\Contracts\KlorchidEloquentModelInterface;
use Kamansoft\Klorchid\Models\Contracts\KlorchidModelInterface;


class KlorchidEloquentModel extends Model implements KlorchidModelInterface, KlorchidEloquentModelInterface

{



    use KlorchidModelsTrait;
    use KlorchidStatusTrait;


}