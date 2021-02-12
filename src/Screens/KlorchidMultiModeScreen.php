<?php

namespace Kamansoft\Klorchid\Screens;

use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Orchid\Screen\Layout;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Dashboard;
use Kamansoft\Klorchid\Repositories\Contracts\KlorchidRepositoryInterface;
use Orchid\Support\Facades\Alert;
use Illuminate\Support\Str;


abstract class KlorchidMultiModeScreen extends Screen {



	private  $klorchid_repository;

	private Collection $available_screen_modes ;


	private Collection $available_repository_actions;

	private Collection $repository_action_validation_rules_methods;

	private Collection $automatic_repository_action_validation_rules_methods;



	private string $current_screen_mode;

	
	public function getRepository(){
		return $this->klorchid_repository;
	}

	public function setRepository($repository):self{
		$this->klorchid_repository=$repository;
		//$this->setActions();
		return $this;
	}




	public function getModes():Collection {
		return $this->available_screen_modes;

	}


	public function getRepositoryActions():Collection{
		 return $this->available_repository_actions;
	}

	public function getRepositoryActionMethod(string $action){
		return $this->available_repository_actions->get($action);

	}




	private function getModesByLayoutMethods(): Collection{
		$reflection = new \ReflectionClass($this);

		return collect($reflection->getMethods(\ReflectionMethod::IS_PUBLIC))->mapWithKeys(function ($method) {
			return [Str::snake(strstr($method->name, 'ModeLayout', true)) => $method->name];
		})->reject(function ($pair) {
			return !strstr($pair, 'ModeLayout', true);
		});

	}


	private function setRepositoryActions():self{

		$reflection = new \ReflectionClass($this->klorchid_repository);
		$this->available_repository_actions=  collect($reflection->getMethods(\ReflectionMethod::IS_PUBLIC))->mapWithKeys(function ($method) {
			return [Str::snake(strstr($method->name, 'Action', true)) => $method->name];
		})->reject(function ($pair) {
			return !strstr($pair, 'Action', true);
		});

		return $this;
	
	}

	private function setRepositoryActionValidations():self{

		$reflection = new \ReflectionClass($this->klorchid_repository);
		$this->repository_action_validation_rules_methods =  collect($reflection->getMethods(\ReflectionMethod::IS_PUBLIC))->mapWithKeys(function ($method) {
			return [Str::snake(strstr($method->name, 'ValidationRules', true)) => $method->name];
		})->reject(function ($pair) {

		    return !strstr($pair, 'ValidationRules', true);
		});

		$this->automatic_repository_action_validation_rules_methods = $this->repository_action_validation_rules_methods
            ->mapWithKeys(function ($method_name,$action_name){
                return [$action_name=>$method_name];
            })->reject(function ($method_name,$action_name){
                return !$this->isValidRepositoryAction($action_name);
            });

		//dd($this->getRepositoryActions(),$this->repository_action_validation_rules_methods,$this->automatic_repository_action_validation_rules_methods);
		return $this;

	}

	public function actionHasValidation(string $action):bool{
		return $this->automatic_repository_action_validation_rules_methods->get($action)?true:false;
	}

	public function getValidationRuleMethod(string $action){
		return $this->repository_action_validation_rules_methods->get($action);
	}

	public function getValidationRules(string $action){
		return $this->getRepository()->{$this->getValidationRuleMethod($action)}();
	}

	public  function setModes(): self{
		//dd($this->getModesByLayoutMethods()->toArray());
		$this->available_screen_modes = $this->getModesByLayoutMethods();
		return $this;
	}




	//related to the current mode
	public function setMode(string $mode) {
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
	

	public function isValidMode(string $mode): bool
    {
        return $this->available_screen_modes->get($mode)?true:false;
    }

    public function isValidRepositoryAction(string $action):bool
    {
	    return $this->getRepositoryActions()->get($action)?true:false;
    }



    /*
    public function isValidAction(string $action):bool
    {
    	return $this->available_repository_actions()->get($action);
    }*/



	

	public function __construct(?KlorchidRepositoryInterface $repository=null) {

		$this->current_screen_mode = 'default';
		$this->setModes();


		if  (! is_null($repository)){
			$this->setRepository($repository)->setRepositoryActions()->setRepositoryActionValidations()->setRepositoryActionValidations();
		}

		//$this->setScreenModePerms($this->screenModePerms());

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
        \Debugbar::info('layout() method, current mode: *'.$current_mode );
		return $mode_layout_array;//array_merge($this->multiModeLayout(), $mode_layout_array);
	}	


	public function runRepositoryAction(string $action,Request $request){

		if ($this->isValidRepositoryAction($action)){
			$this->validateWith($this->getValidationRules($action),$request);
		
	  		return  $this->getRepository()->{$this->getRepositoryActionMethod($action)}();
		}else{
			throw new \Exception(self::class .' "'.$action.'" action name has not a related repository action method',1);
		};
		

    }




    abstract public function defaultModeLayout(): array;


	
}
