<?php

namespace Kamansoft\Klorchid\Screens;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Orchid\Screen\Layout;
use Orchid\Screen\Screen;

abstract class KlorchidMultiModeScreen extends Screen {




	private Collection $available_screen_modes ;

	private Collection $available_repository_actions;

	private string $current_screen_mode;

	public function getModes():Collection {
		return $this->available_screen_modes;

	}

	public function getRepositoryActions():Collection{
		 return $this->available_repository_actions;
	}


	private function getModesByLayoutMethods(): Collection{
		$reflection = new \ReflectionClass($this);

		return collect($reflection->getMethods(\ReflectionMethod::IS_PUBLIC))->mapWithKeys(function ($method) {
			return [strstr($method->name, 'ModeLayout', true) => $method->name];
		})->reject(function ($pair) {
			return !strstr($pair, 'ModeLayout', true);
		});

	}

	private function getActionsFromRepositoryMethods():Collection{

		$reflection = new \ReflectionClass($this->repository);
		return  collect($reflection->getMethods(\ReflectionMethod::IS_PUBLIC))->mapWithKeys(function ($method) {
			return [strstr($method->name, 'Action', true) => $method->name];
		})->reject(function ($pair) {
			return !strstr($pair, 'Action', true);
		});
		return $this;

	
	}

	public  function setModes(): self{
		//dd($this->getModesByLayoutMethods()->toArray());
		$this->available_screen_modes = $this->getModesByLayoutMethods();
		return $this;
	}

	public function setActions(): self{
		$this->available_repository_actions = $this->getActionsFromRepositoryMethods();
		return $this;
	}



	public function setMode(array $mode) {
		if ($this->getModes()->get($mode)) {
			$this->current_screen_mode = $mode;
		} else {
			throw new \Exception(self::class . ' Can\'t set "' . $mode . '" as current screen mode, due to "' . $mode . '" is not an available screen mode. ');
		}
		return $this;
	}

	public function getMode() {
		return $this->current_screen_mode;
	}

	

	public function __construct() {
		$this->current_screen_mode = 'default';
		$this->setModes();

		//$this->setScreenModePerms($this->screenModePerms());

	}

	public function hasPermission(string $perm) {
		return Auth::user()->hasAccess($perm);
	}

	/**
	 * @inheritDoc
	 */
	public function commandBar(): array
	{

	}

	//abstract function multiModeLayout(): array;
	/**
	 * @inheritDoc
	 */
	public function layout(): array
	{
		$current_mode = $this->getMode();
		$method = $this->getModes()->get($current_mode);

		//dd($this->getModes()[$this->getMode()]);
		$mode_layout_array = $this->$method();
        \debugbar::info(self::class.'->layout() method, current mode: *'.$current_mode );
		return $mode_layout_array;//array_merge($this->multiModeLayout(), $mode_layout_array);
	}

	private function repositoryActionDispatch(string $action_name ){
		$this->repository->actionDispatch($action_name);
	}


	abstract public function defaultModeLayout(): array;
	
}
