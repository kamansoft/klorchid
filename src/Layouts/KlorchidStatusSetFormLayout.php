<?php


namespace Kamansoft\Klorchid\Layouts;


use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Select;


/**
 * Class IvalidationReasonFormLayout
 *
 *  to be used only in screens
 *  this needs the screen query to return a form_element_group
 *  name
 *
 * @package App\Orchid\Layouts
 */
class KlorchidStatusSetFormLayout extends KlorchidCurdFormLayout
{


    public function getStatusOptions()
    {
        return collect($this->query->get(model_keyname())::statusStringValues())
            ->mapWithKeys(function ($value, $key) {
                return [
                    $value => __($key)
                ];
            })
            ->toArray();
    }

    public function guessNewStatus(){
        return !$this->query->get(model_keyname())->status;
    }

    /**
     * @return array
     */
    public function formFields(): array
    {

        $model = $this->query->get(model_keyname());
        $show_cur = (!is_null($model->cur_status_reason) and !empty($model->cur_status_reason));

        /*
        $new_status_string = $model->statusToString(!$model->status);
        $new_status_text_class = !$model->status ? 'text-success' : 'text-danger';*/

        $current_status_text_class = $model->status ? 'text-success' : 'text-danger';
        return [

            Input::make(model_keyname('string_status'))
                ->class('form-control ' . $current_status_text_class)
                ->type('text')
                ->title(__('Current Status') . ':')
                ->disabled(true),
            Input::make(model_keyname('cur_status_reason'))
                ->type('text')
                ->canSee($show_cur)
                ->class('form-control text-dark')
                ->title(__('Current Status Reason') . ':'),
            //->disabled(true),

            Select::make(model_keyname('new_status'))
                ->options($this->getStatusOptions())
                ->value($this->guessNewStatus())
                ->title(__('New Status') . ':'),

            Input::make(model_keyname('new_status_reason'))
                ->type('text')
                ->max(255)
                ->min(20)
                ->required()
                ->value("")
                ->title(__('Status Change Reason') . ':')
                ->help(__("Short text or verb that explains the reason of the status change of this element")),


        ];
    }




}
