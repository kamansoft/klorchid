<?php

declare (strict_types = 1);

namespace Kamansoft\Klorchid\Screens;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Orchid\Support\Facades\Alert;
use Orchid\Support\Facades\Dashboard;

/**
 * Trait PermissionsTrait.
 */
trait ScreensPermissionsTrait {

    //listo
	/**
	 * hasPermission
	 *
	 * will check if the logged user has $permission
	 *
	 * @param string $permission
	 * @return bool
	 */
	//listo
	public function hasPermission(string $permission): bool
    {
		if (!Auth::user()->hasAccess($permission)) {
			return false;
		} else {
			return true;
		}

	}

	//listo
	private function getDasboardPermissions() {

		$to_return = Dashboard::getAllowAllPermission();

		return $to_return;

		/*return Dashboard::getPermission()->collapse()
			            ->reduce(static function ($p:rmissions, array $item) {
			                return $permissions->put($item['slug'], true);
		*/
	}

	//listo
	private function permExist($perm): bool{

		/*if (property_exists($this, 'permissionsList') and count($this->permissionsList) > 0) {
			                $permissions_list = $this->permissionsList;
			            } else {
			                $permissions_list = $this->getDasboardPermissions();
			            }
			            //\DeBugbaR::info($permissions_list);
			            //\DeBugbaR::info('permission list');
		*/
		$key_exists = $this->_dashboard_permissions_list->contains($perm);
		if ($key_exists) {
			return $this->_dashboard_permissions_list[$perm];
		} else {
			return false;
		}
	}

	/**
	 *
	 * guessPermKey
	 *
	 * try to determinate the
	 *
	 * @param $tail
	 * @return string
	 * @throws \Exception
	 */
	private function guesPermKey($tail) {
		//\DeBugbaR::info();
		$to_return = '';

		try {
			$permission_prefix = $this->permissions_group;

			$candidate_guessed = $permission_prefix . '.' . $tail;
			$perm_exists = $this->permExist($candidate_guessed);
			if ($perm_exists) {
				$to_return = $candidate_guessed;
			} else {
				throw new \Exception('candidate permission : ' . $candidate_guessed . ' do not exist');
			}
			return $to_return;
		} catch (\Exception $e) {
			throw new \Exception("Unable to determinate permission keyname for form $tail action, " . $e->getMessage());
		}

	}

	/**
	 *
	 * hasFormAccess
	 *
	 * derminate if a user has access to the form, it does data
	 * checking if the user cant edit create or view model data
	 *
	 * @param string|null $edit_perm
	 * @param string|null $create_perm
	 * @param string|null $view_perm
	 * @return bool
	 * @throws \Exception
	 */
	private function hasFormAccess(
		string $edit_perm = null,
		string $create_perm = null,
		string $view_perm = null
	): bool {

		if (\is_null($edit_perm)) {
			$edit_perm = $this->guesPermKey('edit');
		}

		if (\is_null($view_perm)) {
			$edit_perm = $this->guesPermKey('view');
		}

		if (\is_null($create_perm)) {
			$create_perm = $this->guesPermKey('create');
		}

		$has_access = false;
		if ($this->hasPermission($view_perm)
			or $this->hasPermission($edit_perm)
			or $this->hasPermission($create_perm)
		) {
			$has_access = true;
		}
		return $has_access;
	}

	/**
	 *
	 * formFunctionality
	 *
	 * determinates the use of the form: as if the
	 * form will be use only to show data,  edit or create a new
	 * instance of a model (aka table registry)
	 *
	 * @param Model $model the Eloquent  model
	 * @param string|null $edit_perm the permission to edit
	 * @param string|null $create_perm the permission to create
	 * @param string|null $view_perm the permission to view
	 * @return string can be the create, edit, view string
	 * @throws \Exception in case the perms are null and cant be determinated autmatically
	 */
	public function formFunctionality(
		Model $model,
		string $edit_perm = null,
		string $create_perm = null,
		string $view_perm = null
	): string {

		if (\is_null($edit_perm)) {
			$edit_perm = $this->guesPermKey('edit');
		}

		if (\is_null($view_perm)) {
			$view_perm = $this->guesPermKey('view');
		}

		if (\is_null($create_perm)) {
			$create_perm = $this->guesPermKey('create');
		}

		$action = 'simple';

		//\DeBugbaR::info($model);
		//\DeBugbaR::info($edit_perm . ' ' . $view_perm);
		if ($model->exists) {
			if ($this->hasPermission($edit_perm)) {
				$action = "edit";
				//\DeBugbaR::info('Has Edit Perm');
			} elseif ($this->hasPermission($view_perm)) {
				$action = "view";
				//\DeBugbaR::info('Has View Perm');
			}
		} else {
			if ($this->hasPermission($create_perm)) {
				$action = "create";
				//\DeBugbaR::info('Has Create  Perm');
			}
		}

		return $action;
	}

	public function setPermissionErrorAlert(string $object, string $permission_name) {
		Alert::error(__("You have not :object :permission permission", [
			"object" => __($object),
			"permission" => __($permission_name),
		]));
	}

/**
 * check if has acces otherwise returns to route name or back
 * @param  string      $pem_string the string name of the orchid permission to check
 * @param  string|null $route_name the name of the route to redirect
 * @return void
 */
	public function hasPermOrRedirect(string $pem_string, string $route_name = null): void {
		if (!$this->hasPermission($pem_string)) {
			$this->setPermissionErrorAlert('', $pem_string);
			if (!empty($route_name)) {
				redirect($route_name);
			} else {
				redirect()->back();
			}
		}
	}
}
