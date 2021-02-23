<?php


namespace Kamansoft\Klorchid\Repositories;

use Kamansoft\Klorchid\Repositories\Contracts\KlorchidCrudRepositoryInterface;
use Kamansoft\Klorchid\Repositories\Traits\StatusChangeRepositoryTrait;

abstract class KlorchidEloquentCrudRepository extends KlorchidEloquentRepository implements KlorchidCrudRepositoryInterface
{
    use StatusChangeRepositoryTrait;



}