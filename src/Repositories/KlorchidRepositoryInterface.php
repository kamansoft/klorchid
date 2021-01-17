<?php

namespace Kamansoft\Klorchid\Repositories\KorchidRepositoryInterface;
use Illuminate\Database\Eloquent\Model;

/**
 * Interface KlorchidRepositoryInterface
 * @package Kamansoft\Klorchid
 */
interface KlorchidRepositoryInterface
{


    public function create(?array $attributes=null):self;

    public function update(?array $attributes=null):self;

    public function save(?array $attributes=null):self

}
