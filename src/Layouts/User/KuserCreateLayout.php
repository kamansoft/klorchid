<?php

declare(strict_types=1);

namespace Kamansoft\Klorchid\Layouts\User;

use Orchid\Platform\Models\Role;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Password;
use Orchid\Screen\Fields\Select;
use Orchid\Screen\Layout;
use Orchid\Screen\Layouts\Rows;

class KuserCreateLayout extends Rows
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

        return [
            Input::make('element.name')
                ->type('text')
                ->max(255)
                ->required()
                ->title(__('Name'))
                ->placeholder(__('Name')),

            Input::make('element.email')
                ->type('email')
                ->required()
                ->title(__('Email'))
                ->placeholder(__('Email')),

            Password::make('element.password')
                ->required()
                ->placeholder(__('Type User Password'))
                ->title(__('Password')),

            Password::make('element.password_confirmation')
                ->required()
                ->placeholder(__('Retype User Password'))
                ->title(__("Password Confirmation")),


        ];
    }
}
