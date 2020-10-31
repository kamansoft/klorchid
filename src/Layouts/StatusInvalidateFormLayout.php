<?php


namespace Kamansoft\Klorchid\Layouts;


use Orchid\Screen\Field;
use Orchid\Screen\Layouts\Rows;
use Orchid\Screen\Fields\Input;

class StatusInvalidateFormLayout extends \Orchid\Screen\Layouts\Rows
{

    /**
     * @inheritDoc
     */
    protected function fields(): array
    {


        $model = $this->query->get('element');
        $new_status_string = $model->statusToString(false);
        $new_status_text_class =  'text-danger';

        return [



            Input::make('element.new_status')
                ->hidden(true)
                ->value(0),//this value will not be used on method, but is needed as matter of validation
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
                ->title(__('Status Change Reason') . ':')
                ->help(__("Short text or verb that explains the reason of the status change of this element")),


        ];
    }
}
