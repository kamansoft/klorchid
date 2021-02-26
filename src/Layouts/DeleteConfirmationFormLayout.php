<?php


namespace Kamansoft\Klorchid\Layouts;


use Orchid\Screen\Layouts\Rows;
use Orchid\Screen\Fields\Input;

class DeleteConfirmationFormLayout extends Rows
{


    /**
     * Views.
     *
     * @return array
     * @throws \Throwable|\Orchid\Screen\Exceptions\TypeException
     *
     */
    public function fields(): array
    {

        $model =$this->query->get(data_keyname_prefix());
        $confirmation_text = __('Delete').' '.substr($model->{$model->getKeyName()},-12);
        return [
            Input::make(data_keyname_prefix('delete_text'))
                ->value($confirmation_text)
                ->hidden(true),
            Input::make(data_keyname_prefix('delete_text').'_confirmation')
                ->title(__('Confirmation Text'))
                ->placeholder(__('Just type: ') . $confirmation_text)
                ->help(__('Please type :value as confirmation for deleting', ['value' => $confirmation_text]))

        ];
    }
}
