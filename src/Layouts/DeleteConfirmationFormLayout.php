<?php


namespace Kamansoft\Klorchid\Layouts;

use Kamansoft\Klorchid\Layouts\LayoutTrait;
use Orchid\Screen\Layouts\Rows;
use Orchid\Screen\Fields\Input;

class DeleteConfirmationFormLayout extends Rows
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
        $attribute_name =$this->query->get('delete_confirmation_attribute_name');
        //\DeBugbaR::info($attribute_name);
        //\DeBugbaR::info('delete confirmation form layout $attribute name ');

        $model =$this->query->get('element');
        return [
            Input::make('element.'.$attribute_name)
                ->hidden(true),
            Input::make('element.'.$attribute_name.'_confirmation')
                ->title(__('Confirmation Text'))
                ->placeholder(__('Just type: ') . $model->$attribute_name)
                ->help(__('Please type :value as confirmation for deleting', ['value' => $model->$attribute_name]))

        ];
    }
}
