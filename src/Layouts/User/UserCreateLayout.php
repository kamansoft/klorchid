<?php

declare(strict_types=1);

namespace Kamansoft\Klorchid\Layouts\User;

use Orchid\Platform\Models\Role;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Password;
use Orchid\Screen\Fields\Select;
use Orchid\Screen\Layout;
use Orchid\Screen\Layouts\Rows;

class UserCreateLayout extends Rows
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
            Input::make('user.name')
                ->type('text')
                ->max(255)
                ->required()
                ->title(__('Name'))
                ->placeholder(__('Name')),

            Input::make('user.email')
                ->type('email')
                ->required()
                ->title(__('Email'))
                ->placeholder(__('Email')),

            Password::make('user.password')
                ->required()
                ->placeholder(__('Type User Password'))
                ->required()
                ->title(__('Password')),


            Select::make('user.roles.')
                ->fromModel(Role::class, 'name')
                ->multiple()
                ->title(__('Name role'))
                ->help('Specify which groups this account should belong to'),
        ];
    }
}
