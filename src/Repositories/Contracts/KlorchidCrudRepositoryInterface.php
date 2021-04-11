<?php

namespace Kamansoft\Klorchid\Repositories\Contracts;

interface KlorchidCrudRepositoryInterface
{




    public function createAction(?array $data = null):bool;

    public function editAction(?array $data = null):bool;

    public function deleteAction(?array $data = null):bool;

    public function disableAction(?array $data=null):bool;

    public function statusSetAction(?array $data = null):bool;


}