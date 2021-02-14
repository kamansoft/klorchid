<?php

namespace Kamansoft\Klorchid\Repositories\Traits;

trait KlorchidCrudRepositoryTrait
{
        public function save(array $data):bool
        {
            if ($this->exists()) {

                $validation_rules = method_exists($this,updateValidationRules)?$this->updateValidationRules():[];
                $validated_data = count($validation_rules)>0?$this->validate($this->updateValidationRules()):$this->getRequest()->get(data_keyname_prefix());


                if(method_exists($this,updateValidationRules)){
                    $validated_data =
                }else{

                }


                return $this->updateAction($validated_data);
            } else {

                $validation_rules = method_exists($this,createValidationRules)?$this->createValidationRules():[];
                $validated_data = count($validation_rules)>0?$this->validate($this->createValidationRules()):$this->getRequest()->get(data_keyname_prefix());
                return $this->createAction($validated_data);
            }
        }


        public function satusChangeValidationRules():array{
            return [];
        }

        public function statusChangeAction(?array $data = null):bool{

        }

}