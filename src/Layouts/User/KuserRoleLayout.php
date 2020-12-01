<?php

declare (strict_types=1);

namespace Kamansoft\Klorchid\Layouts\User;

use Kamansoft\Klorchid\Layouts\LayoutTrait;
use Orchid\Platform\Models\Role;
use Orchid\Screen\Fields\Select;
use Orchid\Screen\Layouts\Rows;

class KuserRoleLayout extends Rows
{
    use LayoutTrait;
    /**
     * Views.
     *
     * @return array
     */
    public function fields(): array
    {
        $action = $this->query->get('form_action');
        $user = $this->query->get('element');


        $is_disabled = !$this->isEditable($user);
        $field_class = 'form-control ' . $this->getFieldCssClass($user);
        return [
            Select::make('element.roles.')
                ->fromModel(Role::class, 'name')
                ->multiple()
                ->disabled($is_disabled)
                ->class($field_class)
                ->title(__('Name role'))
                ->help('Specify which groups this account should belong to'),
        ];
    }
}
