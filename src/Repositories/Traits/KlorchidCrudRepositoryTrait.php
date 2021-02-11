<?php

namespace Kamansoft\Klorchid\Repositories\Traits;

trait KlorchidCrudRepositoryTrait
{
        public function save(?array $data=null)
        {
            if ($this->exists()) {
                $this->validateOnUpdate($data);
                return $this->updateAction($data);
            } else {
                $this->validateOnCreate($data);
                return $this->createAction($data);
            }
        }




}