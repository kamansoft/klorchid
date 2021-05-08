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
    public function statusFields($data_keyname, $field_class = null): array
    {
        return [
            $this->statusField($data_keyname, $field_class),
            $this->statusReasonField($data_keyname, $field_class),
        ];
    }

    public function statusField($data_keyname, $field_class = null): Field
    {
        $field_class = $field_class ?: 'form-control ' . $this->getModel()->statusPresenter()->getStatusFieldColorClass();
        return Input::make('statusNamePresentation')
            ->value($this->getModel()->statusPresenter()->currentStatus())
            ->class($field_class) //. $this->getFieldCssClass($model))
            ->type('text')
            ->title(__('Current Status') . ':')
            ->canSee($this->query->get($data_keyname)->exists)
            ->disabled(true);
    }

    public function statusReasonField($data_keyname, $field_class = null): Field
    {
        $field_class = $field_class ?: 'form-control ' . $this->getModel()->statusPresenter()->getStatusFieldColorClass();

        return TextArea::make(implodeWithDot($data_keyname, 'cur_status_reason'))
            ->class($field_class)
            ->title(__('Current Status Reason') . ': ')
            ->canSee($this->query->get($data_keyname)->exists)
            ->disabled(true);
    }

    public function newStatusField($data_keyname, $status_options): Field
    {
        return Select::make(implodeWithDot($data_keyname, 'new_status'))
            ->options($status_options)
            ->title(__('New Status') . ':');
    }

    public function newStatusReasonField($data_keyname): Field
    {
        return Input::make(implodeWithDot($data_keyname, 'new_status_reason'))
            ->type('text')
            ->max(255)
            ->min(20)
            ->required()
            ->value("")
            ->title(__('Status Change Reason') . ':')
            ->help(__("Short text or verb that explains the reason of the status change of this element"));

    }

    public function newStatusFields($data_keyname, $status_options): array
    {
        return [
            $this->newStatusField($data_keyname, $status_options),
            $this->newStatusReasonField($data_keyname)
        ];
    }


}