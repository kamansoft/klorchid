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

    public function statusFields($creen_query_model_keyname, $field_class = null): array
    {
        return [
            $this->statusField($creen_query_model_keyname, $field_class),
            $this->statusReasonField($creen_query_model_keyname, $field_class),
        ];
    }

    public function statusField($creen_query_model_keyname, $field_class = null): Field
    {
        $field_class = $field_class ?: 'form-control ' . $this->getModel()->statusPresenter()->getStatusFieldColorClass();
        return Input::make('statusNamePresentation')
            ->value($this->getModel()->statusPresenter()->currentStatus())
            ->class($field_class) //. $this->getFieldCssClass($model))
            ->type('text')
            ->title(__('Current Status') . ':')
            ->canSee($this->getModel()->exists)
            ->disabled(true);
    }

    public function statusReasonField($creen_query_model_keyname, $field_class = null): Field
    {
        $field_class = $field_class ?: 'form-control ' . $this->getModel()->statusPresenter()->getStatusFieldColorClass();

        return TextArea::make($creen_query_model_keyname)
            ->class($field_class)
            ->title(__('Current Status Reason') . ': ')
            ->canSee($this->getModel()->exists)
            ->disabled(true);
    }

    public function newStatusField($creen_query_model_keyname, $status_options): Field
    {
        return Select::make(implodeWithDot($creen_query_model_keyname, 'new_status'))
            ->options($status_options)
            ->title(__('New Status') . ':');
    }

    public function newStatusReasonField($creen_query_model_keyname): Field
    {
        return Input::make(implodeWithDot($creen_query_model_keyname, 'new_status_reason'))
            ->type('text')
            ->max(255)
            ->min(20)
            ->required()
            ->value("")
            ->title(__('Status Change Reason') . ':')
            ->help(__("Short text or verb that explains the reason of the status change of this element"));

    }

    public function newStatusFields($creen_query_model_keyname, $status_options): array
    {
        return [
            $this->newStatusField($creen_query_model_keyname, $status_options),
            $this->newStatusReasonField($creen_query_model_keyname)
        ];
    }


}