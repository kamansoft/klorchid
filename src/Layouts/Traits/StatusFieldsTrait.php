<?php


namespace Kamansoft\Klorchid\Layouts\Traits;

use Orchid\Screen\Field;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Select;
use Orchid\Screen\Fields\TextArea;

/**
 * Trait StatusFieldsTrait
 * @package Kamansoft\Klorchid\Layouts\Traits
 * @property \Orchid\Screen\Repository query
 */
trait StatusFieldsTrait
{



    public function statusFields($screen_query_model_keyname,?string $field_class = null): array
    {
        return [
            'status_text'=>$this->statusField($screen_query_model_keyname, $field_class),
            'status_reason'=>$this->statusReasonField($screen_query_model_keyname, $field_class),
        ];
    }

    public function statusField($screen_query_model_keyname,?string $field_class = null): Field
    {
        $field_class = $field_class ?: 'form-control text-' . $this->getModel()->getStatusColorClass();
        \Debugbar::info($field_class);
        return Input::make(implodeWithDot($screen_query_model_keyname,'statusNamePresentation'))
            ->value($this->getModel()->statusPresenter()->currentStatus())
            ->class($field_class) //. $this->getFieldCssClass($model))
            ->type('text')
            ->title(__('Current Status') . ':')
            ->canSee($this->getModel()->exists)
            ->disabled(true);
    }

    public function statusReasonField($screen_query_model_keyname,?string $field_class = null): Field
    {
        $field_class = $field_class ?: 'form-control text-' . $this->getModel()->getStatusColorClass();



        return TextArea::make(implodeWithDot($screen_query_model_keyname,config('klorchid.models_common_field_names.reason')))
            ->class($field_class)

            ->title(__('Current Status Reason') . ': ')
            ->canSee($this->getModel()->exists)
            ->disabled(true);
    }

    public function newStatusField($screen_query_model_keyname,array $status_options): Field
    {
        return Select::make(implodeWithDot($screen_query_model_keyname, 'new_status'))
            ->options($status_options)
            ->title(__('New Status') . ':');
    }

    public function newStatusReasonField($screen_query_model_keyname): Field
    {
        return Input::make(implodeWithDot($screen_query_model_keyname, 'new_status_reason'))
            ->type('text')
            ->max(255)
            ->min(20)
            ->required()
            ->value("")
            ->title(__('Status Change Reason') . ':')
            ->help(__("Short text or verb that explains the reason of the status change of this element"));

    }

    public function newStatusFields($screen_query_model_keyname,array $status_options): array
    {
        return [
            $this->newStatusField($screen_query_model_keyname, $status_options),
            $this->newStatusReasonField($screen_query_model_keyname)
        ];
    }


}