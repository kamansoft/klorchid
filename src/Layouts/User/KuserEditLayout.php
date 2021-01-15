<?php

declare(strict_types=1);

namespace Kamansoft\Klorchid\Layouts\User;

use Orchid\Screen\Fields\Input;
use Orchid\Screen\Layouts\Rows;
use Kamansoft\Klorchid\Layouts\LayoutTrait;

class KuserEditLayout extends Rows
{
    use LayoutTrait;
    /**
     * Views.
     *
     * @return array
     */
    public function fields(): array
    {
        $action  =$this->query->get('form_action');
        $user = $this->query->get('element');


        $is_disabled = !$this->isEditable($user);
        //\Debugbar::info($is_disabled);
        //\Debugbar::info('KuserEditLayout fields is_disable');
        $field_class  = 'form-control '.$this->getFieldCssClass($user);
        return [
            Input::make('element.id')
                ->type('text')
                ->title(__('Id'))
                ->canSee(($action !== 'create'))
                ->class($field_class)
                ->disabled(true),
            Input::make('element.stringStatus')
                ->type('text')
                ->canSee(($action !== 'create' and $user->status==false))
                ->title(__('Status'))
                ->class($field_class)
                ->disabled(true),
            Input::make('element.name')
                ->type('text')
                ->max(255)
                ->required()
                ->class($field_class)
                ->title(__('Name'))
                ->disabled($is_disabled)
                ->placeholder(__('Name')),

            Input::make('element.email')
                ->type('email')
                ->required()
                ->class($field_class)
                ->title(__('Email'))
                ->disabled($is_disabled)
                ->placeholder(__('Email')),


        ];
    }
}
