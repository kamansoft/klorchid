<?php


namespace Kamansoft\Klorchid\Models;


use Kamansoft\Klorchid\Models\Traits\BinaryStatusModelTrait;

abstract class KlorchidBinaryStatusModel extends KlorchidMultiStatusEloquentModel
{
    use BinaryStatusModelTrait;

}