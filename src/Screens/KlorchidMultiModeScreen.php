<?php

namespace Kamansoft\Klorchid\Screens;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Orchid\Screen\Layout;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Dashboard;
use Kamansoft\Klorchid\Repositories\KlorchidRepositoryInterface;


abstract class KlorchidMultiModeScreen extends Screen {



	private $repository;

	private Collection $available_screen_modes ;

	private Collection $available_repository_actions;



	private string $current_screen_mode;

	
	public function getRepository(){
		return $this->repository;
	}

	public function setRepository($repository){
		$this->repository=$repository;
		$this->setActions();
		return $this;
	}


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



	//related to the current mode
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
	//\related to the current mode 
	

	public function isValidMode(string $mode): boolean
    {
        return $this->available_screen_modes->get($mode)?true:false;
    }

    public function isValidPerm(string $perm): boolean
    {
        return  Dashboard::getAllowAllPermission()->get($perm) ? true : false;
    }

    public function isValidAction(string $action):boolean
    {
    	return $this->available_repository_actions()->get($action);
    }



	

	public function __construct(?KlorchidRepositoryInterface $repository=null) {
		$this->current_screen_mode = 'default';
		$this->setModes();


		if  (! is_null($repository)){
			$this->setRepository($repository);
		}


		//$this->setScreenModePerms($this->screenModePerms());
		//
		
		


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
		return $this->$action_name;
	}


	abstract public function defaultModeLayout(): array;
	
}
