<?php


namespace Kamansoft\Klorchid\Models;


use Kamansoft\Klorchid\Models\Contracts\BooleanStatusModelInterface;
use Kamansoft\Klorchid\Models\Contracts\KlorchidMultiStatusModelInterface;
use Kamansoft\Klorchid\Models\Traits\BooleanStatusModelTrait;

class KlorchidBooleanStatusModel extends KlorchidMultiStatusModel implements  BooleanStatusModelInterface
{
    use BooleanStatusModelTrait;


}