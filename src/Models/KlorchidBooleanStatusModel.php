<?php


namespace Kamansoft\Klorchid\Models;


use Kamansoft\Klorchid\Models\Contracts\BooleanStatusModelInterface;
use Kamansoft\Klorchid\Models\Contracts\StatusModelInterface;
use Kamansoft\Klorchid\Models\Traits\BooleanStatusModelTrait;

class KlorchidBooleanStatusModel extends KlorchidEloquentModel implements StatusModelInterface, BooleanStatusModelInterface
{
    use BooleanStatusModelTrait;

}