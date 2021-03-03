<?php


namespace Kamansoft\Klorchid\Models;


use Illuminate\Database\Eloquent\Model;
use Kamansoft\Klorchid\Models\Contracts\BinaryStatusKlorchidModelsInterface;
use Kamansoft\Klorchid\Models\Contracts\KlorchidModelsInterface;
use Kamansoft\Klorchid\Models\Traits\BinaryStatusModelsTrait;

/*
use Kamansoft\Klorchid\Models\Traits\KlorchidEloquentModelsTrait;
use Kamansoft\Klorchid\Models\Traits\KlorchidModelsStatusValuesTrait;
use Kamansoft\Klorchid\Models\Traits\KlorchidUserBlamingModelsTrait;*/

class BinaryStatusKlorchidEloquentModels extends Model implements KlorchidModelsInterface, BinaryStatusKlorchidModelsInterface
{


    use BinaryStatusModelsTrait;

    /*use KlorchidModelsStatusTrait;
  use KlorchidUserBlamingModelsTrait;
  use KlorchidEloquentModelsTrait;*/
}