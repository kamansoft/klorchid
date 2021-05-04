<?php


namespace Kamansoft\Klorchid\Models;


use Kamansoft\Klorchid\Models\Contracts\KlorchidMultiStatusModelInterface;
use Kamansoft\Klorchid\Models\Traits\KlorchidMultiStatusModelTrait;

abstract class KlorchidMultiStatusModel extends KlorchidEloquentModel implements  KlorchidMultiStatusModelInterface
{
    use KlorchidMultiStatusModelTrait;
}