<?php


namespace Kamansoft\Klorchid\Layouts;


use Orchid\Screen\Layouts\Rows;
use Orchid\Screen\Fields\Input;


/**
 * Class IvalidationReasonFormLayout
 *
 *  to be used only in screens
 *  this needs the screen query to return a form_element_group
 *  name
 *
 * @package App\Orchid\Layouts
 */
class StatusToggleFormLayout extends Rows
{

    use LayoutTrait;

    /**
     * Views.
     *
     * @return array
     * @throws \Throwable|\Orchid\Screen\Exceptions\TypeException
     *
     */
    public function fields(): array
    {


        $show_cur= ! is_null($this->query->get('element')->cur_status_reason);
        $model = $this->query->get('element');
        $new_status_string = $model->statusToString(!$model->status);
        $new_status_text_class = !$model->status?'text-success':'text-danger';
        $current_status_text_class = $model->status?'text-success':'text-danger';
        return [

            Input::make('element.string_status')
                ->class('form-control '.$current_status_text_class)
                ->type('text')
                ->title(__('Current Status').':')
                ->disabled(true),
            Input::make('element.cur_status_reason')
                ->type('text')
                ->canSee($show_cur)
                ->class('form-control text-dark')
                ->title(__('Current status Reason').':')
                ->disabled(true),

            Input::make('element.new_status')
                ->hidden(true)
                ->value(1),//this value will not be used on method, but is needed as matter of validation
            Input::make('element.new_string_status')
                ->class('form-control '.$new_status_text_class)
                ->value($new_status_string)
                ->type('text')
                ->title(__('New Status').':')
                ->disabled(true),
            Input::make('element.new_status_reason')
                ->type('text')
                ->max(255)
                ->min(20)
                ->required()
                ->value("")
                ->title(__('Status Change Reason').':')
                ->help(__("Short text or verb that explains the reason of the status change of this element")),



        ];
    }


}
