<?php

namespace Kamansoft\Klorchid\Repositories\Traits;

trait KlorchidCrudRepositoryTrait
{
        public function save(?array $data=null)
        {
            if ($this->exists()) {
                //$this->validate($this->updateValidationRules());
                return $this->updateAction($data);
            } else {
                //$this->validate($this->createValidationRules());
                return $this->createAction($data);
            }
        }




}