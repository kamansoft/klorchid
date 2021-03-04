<?php


namespace Kamansoft\Klorchid\Repositories\Traits;

/**
 * Trait StatusChangeRepositoryTrait
 * @package klorchid\src\Repositories\Traits
 * @target
 */
trait StatusChangeRepositoryTrait
{

    public function statusSetValidationRules():array{
        return [
            data_keyname_prefix('new_status') => 'required|boolean',
            data_keyname_prefix('new_status_reason') => 'required|string|min:15'
        ];
    }
    public function disableValidationRules(){
        return $this->statusChangeValidationRules();
    }


    public function statusSetAction(?array $data = null): bool
    {

        $model = $this->getModel();
        $model->status = $data['new_status'];
        $model->cur_status_reason = $data['new_status_reason'];
        return $model->save();
    }

    public function disableAction(?array $data = null): bool
    {
        return $this->statusSetAction(false);
    }


}