<?php

namespace Kamansoft\Klorchid\Screens;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Orchid\Screen\Layout;
use Orchid\Screen\Screen;

abstract class KlorchidMultiModeScreen extends Screen {

	private Collection $available_screen_modes ;

	private string $current_screen_mode;

	public function getModes():Collection {
		return $this->available_screen_modes;

	}
	private function getModesByLayoutMethods(): Collection{
		$reflection = new \ReflectionClass($this);

		return collect($reflection->getMethods(\ReflectionMethod::IS_PUBLIC))->mapWithKeys(function ($method) {
			return [strstr($method->name, 'ModeLayout', true) => $method->name];
		})->reject(function ($pair) {
			return !strstr($pair, 'ModeLayout', true);
		});

	}

	private function setModes(): self{
		//dd($this->getModesByLayoutMethods()->toArray());
		$this->available_screen_modes = $this->getModesByLayoutMethods();
		return $this;
	}

	/*
		    public function pushModes(string $mode ){
		        if (! in_array($mode,$this->available_screen_modes)){
		            array_push($mode,$this->available_screen_modes);
		        }
		        return $this;
		    }

		    public function setModes(array $modes){
		        foreach ($modes as $mode){
		            $this->pushModes($mode);
		        }
		        return $this;
	*/

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

	abstract public function defaultModeLayout(): array;

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
		// TODO: Implement commandBar() method.
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
        \debugbar::info(self::class.'->layout() method, current mode: <'.$current_mode );
		return $mode_layout_array;//array_merge($this->multiModeLayout(), $mode_layout_array);
	}
}
