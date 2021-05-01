<?php


namespace Kamansoft\Klorchid\Http\Request;

use Illuminate\Database\Eloquent\Model;
use Kamansoft\Klorchid\Layouts\KlorchidFormLayout;
use Kamansoft\Klorchid\Support\Facades\Notificator;
use Illuminate\Support\Facades\Log;


abstract class KlorchidRequest extends \Illuminate\Foundation\Http\FormRequest
{

    public abstract function entityName():string;

    /**
     * Performs a common tasks that include notification on update or create a new item
     *
     * @param \Kamansoft\Klorchid\Model $model to fill with data
     * @param string|array $data_to_store  if a string it will be taken as the keyname of the request inputs values subset
     * to fill the model with. If is an array it will be taken as the values to fill the model with.
     * @return bool
     */
    public function store(Model $model,$data_to_store=null): bool
    {
        $isUpdating = $model->exists;
        if (is_string($data_to_store) and  !is_null($this->get($data_to_store))){
            $data_to_store=$this->get($data_to_store);
        }elseif (!is_array($data_to_store) ){

            $data_to_store = $this->get(KlorchidFormLayout::$screen_query_form_data_keyname);
        }
       $save_performed = $model->fill($data_to_store)->save();
        $message_data = [
            'element' => __($this->entityName()),
            'id' => $model->pkPresenter()->shortPk()
        ];
        Notificator::setMode("alert");
        if ($save_performed) {
            $message = $isUpdating ?
                __('Success on Updating :element, record with id: :id', $message_data) :
                __('Success on Creating :element, new record with id: :id', $message_data);
            Notificator::success($message);
            Log::info($message);
        } else {
            $message = __('Unable to save element :element :id', $message_data);
            Notificator::error($message);
            Log::warning($message);
        }

        return $save_performed;
    }


    public function rules(){
        return empty($this->all())?[]:$this->validationRules();
    }
    abstract function validationRules():array;


}