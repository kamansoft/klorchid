<?php

namespace Kamansoft\Klorchid\Repositories\Contracts;

interface KlorchidCrudRepositoryInterface
{

    public function statusChangeValidationRules(): array;

    public function deleteValidationRules(): array;

    public function createValidationRules(): array;

    public function editValidationRules(): array;


    public function createAction(?array $data = null);

    public function updateAction(?array $data = null);

    public function deleteAction(?array $data = null);

    public function statusChangeAction(?array $data = null);
}