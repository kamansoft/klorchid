<?php


namespace Kamansoft\Klorchid\Models;


use Kamansoft\Klorchid\Models\Contracts\BooleanStatusModelInterface;
use Kamansoft\Klorchid\Models\Contracts\IntegerStatusModelInterface;
use Kamansoft\Klorchid\Models\Contracts\StatusModelInterface;
use Kamansoft\Klorchid\Models\Traits\BooleanStatusModelTrait;
use Kamansoft\Klorchid\Models\Traits\IntegerStatusModelTrait;
use Ramsey\Uuid\Type\Integer;

abstract class KlorchidIntegerStatusModel extends KlorchidEloquentModel implements StatusModelInterface, IntegerStatusModelInterface
{
    use IntegerStatusModelTrait;
}