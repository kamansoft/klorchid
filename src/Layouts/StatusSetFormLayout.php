<?php


namespace Kamansoft\Klorchid\Layouts;


use Orchid\Screen\Layouts\Rows;
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
class StatusSetFormLayout extends Rows
{

    use LayoutTrait;

    /**
     * @return array
     */
    public function fields(): array
    {

        $model = $this->query->get(data_keyname_prefix());
        $show_cur = (!is_null($model->cur_status_reason)and !empty($model->cur_status_reason) );

        /*
        $new_status_string = $model->statusToString(!$model->status);
        $new_status_text_class = !$model->status ? 'text-success' : 'text-danger';*/

        $current_status_text_class = $model->status ? 'text-success' : 'text-danger';
        return [

            Input::make(data_keyname_prefix('string_status'))
                ->class('form-control ' . $current_status_text_class)
                ->type('text')
                ->title(__('Current Status') . ':')
                ->disabled(true),
            Input::make(data_keyname_prefix('cur_status_reason'))
                ->type('text')
                ->canSee($show_cur)
                ->class('form-control text-dark')
                ->title(__('Current status Reason') . ':'),
                //->disabled(true),

            Select::make(data_keyname_prefix('new_status'))
                ->options($model::statusStringValues())

                ->title(__('New Status') . ':'),

            Input::make(data_keyname_prefix('new_status_reason'))
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
