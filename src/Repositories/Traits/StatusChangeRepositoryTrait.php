<?php


namespace Kamansoft\Klorchid\Repositories\Traits;

use Illuminate\Database\Eloquent\Model;

/**
 * Trait StatusChangeRepositoryTrait
 * @package klorchid\src\Repositories\Traits
 * @target
 */
trait StatusChangeRepositoryTrait
{

    public function statusSetValidationRules():array{

        $table = $this->getModel()->getTable();

        return [
            model_keyname('new_status') => 'required|boolean',
            model_keyname('new_status_reason') => 'required|string|unique:'.$table.',cur_status_reason|min:15'
        ];
    }
    public function disableValidationRules(){
        return $this->statusChangeValidationRules();
    }


    public function statusSetAction(?array $data = null): bool
    {
        $validated_data = $this->validate($data,$this->statusSetValidationRules());
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