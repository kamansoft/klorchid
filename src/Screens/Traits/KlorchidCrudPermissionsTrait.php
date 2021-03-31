<?php

namespace  Kamansoft\Klorchid\Screens\Traits;

use function PHPUnit\Framework\objectHasAttribute;

trait KlorchidCrudPermissionsTrait
{

    public Collection $crudPermissions;

    public function getCrudPermissionsByGroupName($groupname){
        return collect(Dashboard::getPermission()->get($groupname))->mapWithKeys(function($element){
            return [Str::snake($element['description'])=>$element['slug']];
        });
    }

    public function getCrudPermissionsByPrefix($prefix){
        dd(Dashboard::getPermission());
    }


    public function setCrudPermissions(){


        if (property_exists($this,'curd_premissions_group') and !is_null($this->curd_premissions_group)){
            //$group = $this->curd_premissions_group;
            $permissions = $this->getCrudPermissionsByGroupName($this->curd_premissions_group);
        }

        if (property_exists($this,'crud_prmissions_prefix') and !is_null($this->crud_prmissions_prefix)){
            //$group = $this->crud_prmissions_prefix;

        }

        return $this;
    }

    public function getCrudPerm(string $action)
    {
        return $this->crudPermissions->get($action);
    }

}