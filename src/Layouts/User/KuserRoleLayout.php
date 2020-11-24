<?php

declare (strict_types = 1);

namespace Kamansoft\Klorchid\Layouts\User;

use Orchid\Platform\Models\Role;
use Orchid\Screen\Fields\Select;
use Orchid\Screen\Layouts\Rows;

class KuserRoleLayout extends Rows {
	/**
	 * Views.
	 *
	 * @return array
	 */
	public function fields(): array
	{
		return [
			Select::make('element.roles.')
				->fromModel(Role::class, 'name')
				->multiple()
				->title(__('Name role'))
				->help('Specify which groups this account should belong to'),
		];
	}
}
