<?php


namespace Kamansoft\Klorchid\Models;


use Kamansoft\Klorchid\Models\Contracts\MultiStatusModelInterface;
use Kamansoft\Klorchid\Models\Traits\MultiStatusModelTrait;

abstract class KlorchidMultiStatusEloquentModel extends KlorchidEloquentModel implements MultiStatusModelInterface
{

    use MultiStatusModelTrait;
}