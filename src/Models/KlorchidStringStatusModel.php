<?php


namespace Kamansoft\Klorchid\Models;


use Kamansoft\Klorchid\Models\Contracts\KlorchidMultiStatusModelInterface;
use Kamansoft\Klorchid\Models\Contracts\StringStatusModelInterface;
use Kamansoft\Klorchid\Models\Traits\StringStatusModelTrait;

abstract class KlorchidStringStatusModel extends KlorchidMultiStatusModel implements  StringStatusModelInterface
{
    use StringStatusModelTrait;
}