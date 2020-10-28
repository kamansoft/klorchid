<?php

declare (strict_types=1);

namespace Kamansoft\Klorchid\Screens;

use Illuminate\Support\Facades\Auth;
use Orchid\Support\Facades\Alert;
use Illuminate\Database\Eloquent\Model;
use Orchid\Support\Facades\Dashboard;

/**
 * Trait PermissionsTrait.
 */
trait ScreensPermissionsTrait
{

    /**
     * hasPermission
     *
     * will check if the logged user has $permission
     *
     * @param string $permission
     * @return bool
     */
    public function hasPermission(string $permission): bool
    {
        if (!Auth::user()->hasAccess($permission)) {

            return false;
        } else {
            return true;
        }

        return false;
    }

    private function getDasboardPermissions(){
        return Dashboard::getPermission()->collapse()
            ->reduce(static function ($permissions, array $item) {
                return $permissions->put($item['slug'], true);
            }, collect())->all();
    }
    private function permExist($perm)
    {

        if (property_exists($this,'permissionsList') and count($this->permissionsList)>0){
            $permissions_list = $this->permissionsList;
        }else{
            $permissions_list = $this->getDasboardPermissions();
        }


        return array_key_exists($perm,$permissions_list);
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
    private function guesPermKey($tail)
    {
        \Debugbar::info();
        $to_return = '';


        try {
            $permission_prefix = $this->permissions_group;

            $candidate_guessed = $permission_prefix . '.' . $tail;

            if ($this->permExist($candidate_guessed)) {
                $to_return = $candidate_guessed;
            } else {
                throw new \Exception('candidate permission : ' . $candidate_guessed . ' do not exist');
            }
            return $to_return;
        } catch (\Exception $e) {
            throw new \Exception("Unable to determinate permission keyname for form $tail action, ". $e->getMessage());
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
    ): bool
    {

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
    ): string
    {

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

        \Debugbar::info($model);
        \Debugbar::info($edit_perm . ' ' . $view_perm);
        if ($model->exists) {
            if ($this->hasPermission($edit_perm)) {
                $action = "edit";
                \Debugbar::info('Has Edit Perm');
            } elseif ($this->hasPermission($view_perm)) {
                $action = "view";
                \Debugbar::info('Has View Perm');
            }
        } else {
            if ($this->hasPermission($create_perm)) {
                $action = "create";
                \Debugbar::info('Has Create  Perm');
            }
        }

        return $action;
    }


    public function setPermissionErrorAlert(string $object,string $permission_name){
        Alert::error(__("You have not :object :permission permission", [
                "object" => __($object),
                "permission" => __($permission_name),
        ]));
    }
}
