<?php 


namespace Kamansoft\Klorchid\Repositories;



interface ActionPermissionRepositoryInterface {

    function setActionMethods(): self;
	public function getActionsPermission(): array;


}
