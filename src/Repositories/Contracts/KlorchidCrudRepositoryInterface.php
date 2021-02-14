<?php

namespace Kamansoft\Klorchid\Repositories\Contracts;

interface KlorchidCrudRepositoryInterface
{




    public function createAction(?array $data = null):bool;

    public function updateAction(?array $data = null):bool;

    public function deleteAction(?array $data = null):bool;

    public function statusChangeAction(?array $data = null):bool;

    public function satusChangeValidationRules():array;
}