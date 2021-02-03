<?php

namespace Kamansoft\Klorchid\Repositories;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
//use Orchid\Platform\Dashboard;
//use Orchid\Screen\Layouts\Selection;

use Kamansoft\Klorchid\Notificator\NotificaterInterface;
use Kamansoft\Klorchid\Repositories\KlorchidEloquentBasedRepository;
use Orchid\Support\Facades\Dashboard;

trait ActionPermissionRepositoryTrait  {

	private Collection $actionMethods;


	private function setActionMethos(): self{
		$reflection = new \ReflectionClass($this);
		$this->actionMethods = collect($reflection->getMethods(\ReflectionMethod::IS_PUBLIC))->mapWithKeys(function ($method) {
			return [strstr($method->name, 'Action', true) => $method->name];
		})->reject(function ($pair) {
			return !strstr($pair, 'Action', true);
		});
		return $this;

	}

	public function isValidPerm(string $perm): bool {
		return Dashboard::getAllowAllPermission()->get($perm) ? true : false;
	}

	public function isValidAction(string $action):bool{
		return $this->actionMethods->get($action)?true:false;	
	}

	private function checkActionPermission() {
		collect($this->getActionsPermission())->map(function ($action, $perm) {
			echo $action.' '.$perm;
		});
		return $this;
	}



	public function __construct(Model $model, Request $request, NotificaterInterface $notificator) //, Dashboard $gui)
	{

		parent::__construct($model, $request, $notificator);
		$this->setActionMethos()->checkActionPermission();

	}


}