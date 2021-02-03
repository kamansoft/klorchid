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

abstract class EloquentActionPermissedRepository extends KlorchidEloquentBasedRepository {

	private Collection $actionMethods;

	/**
	 * should returns a key value pair array with the name of the action and the valid permission
	 * like ["action"=>"platform.valid.permission"]
	 * @return array action name and permission pair
	 */
	abstract public function getActionsPermission(): array;

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

	private function checkActionPermission() {
		collect($this->getActionsPermission())->map(function ($action, $perm) {
			dd($action, $perm);
		});
		return $this;
	}

	public function __construct(Model $model, Request $request, Notifica
	terInterface $notificator) //, Dashboard $gui)
	{

		parent::__construct($model, $request, $notificator);
		$this->setActionMethos()->checkActionPermission();

	}
}