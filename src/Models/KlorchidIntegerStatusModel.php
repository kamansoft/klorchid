<?php


namespace Kamansoft\Klorchid\Models;


use Kamansoft\Klorchid\Models\Contracts\BooleanStatusModelInterface;
use Kamansoft\Klorchid\Models\Contracts\IntegerStatusModelInterface;
use Kamansoft\Klorchid\Models\Contracts\KlorchidMultiStatusModelInterface;
use Kamansoft\Klorchid\Models\Traits\BooleanStatusModelTrait;
use Kamansoft\Klorchid\Models\Traits\IntegerStatusModelTrait;
use Ramsey\Uuid\Type\Integer;

abstract class KlorchidIntegerStatusModel extends KlorchidMultiStatusModel implements  IntegerStatusModelInterface
{
    use IntegerStatusModelTrait;
}