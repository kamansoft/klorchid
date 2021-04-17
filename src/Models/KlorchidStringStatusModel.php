<?php


namespace Kamansoft\Klorchid\Models;


use Kamansoft\Klorchid\Models\Contracts\StatusModelInterface;
use Kamansoft\Klorchid\Models\Contracts\StringStatusModelInterface;
use Kamansoft\Klorchid\Models\Traits\StringStatusModelTrait;

abstract class KlorchidStringStatusModel extends KlorchidEloquentModel implements StatusModelInterface, StringStatusModelInterface
{
    use StringStatusModelTrait;
}