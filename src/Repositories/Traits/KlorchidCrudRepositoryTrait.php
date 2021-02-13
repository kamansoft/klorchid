<?php

namespace Kamansoft\Klorchid\Repositories\Traits;

trait KlorchidCrudRepositoryTrait
{
        public function save()
        {
            if ($this->exists()) {
                $this->validate($this->updateValidationRules());
                return $this->updateAction($data);
            } else {
                $this->validate($this->updateValidationRules());
                return $this->createAction($data);
            }
        }




}