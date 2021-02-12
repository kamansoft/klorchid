<?php

namespace Kamansoft\Klorchid\Repositories\Contracts;

use Illuminate\Database\Eloquent\Model;

/**
 * Interface KlorchidRepositoryInterface
 * @package Kamansoft\Klorchid
 */
interface KlorchidRepositoryInterface
{
    //public function getConfirmationAttribute():string;

    public function getModel(): Model;

    public function setModel(?Model $model = null): self;

    public function exists():bool;

    public function isPkInRequest():bool;

    public function getPkValue();

    public function save(?array $data);




    








}
