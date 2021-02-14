<?php

namespace Kamansoft\Klorchid\Screens;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Kamansoft\Klorchid\Repositories\Contracts\KlorchidRepositoryInterface;
use Orchid\Screen\Layout;
use Orchid\Support\Facades\Dashboard;
use Kamansoft\Klorchid\KlorchidPermissionTrait;
use Illuminate\Http\Request;

abstract class KlorchidCrudScreen extends KlorchidMultiModeScreen {

	use KlorchidPermissionTrait;

	private Collection $klorchid_screen_modes_perms;

	public function getScreenModePerms(): Collection {
		return $this->klorchid_screen_modes_perms;
	}
	public function getScreenModePerm(string $mode) {
		return $this->klorchid_screen_modes_perms->get($mode);
	}

	private function setScreenModePerms(): self{

		$mode_perms = collect($this->screenModePerms())->mapWithKeys(function ($perm, $mode) {
			if (!$this->isValidMode($mode)) {
				throw new \Exception("instance of class: " . self::class . " has not an asociated method for \"$mode\" mode", 1);
			}
			if (!$this->isValidPerm($perm)) {
				throw new \Exception(self::class . ":  \"$perm\" is not a valid permission key.", 1);
			}
			return [$mode => $perm];
		})->reject(function ($perm, $mode) {
			return (!$this->isValidPerm($perm) and !$this->isValidMode($mode));
		});

		$this->klorchid_screen_modes_perms = $mode_perms;
		return $this;
	}



	public function detectScreenModeLayout(): string{
		$mode_to_return = $this->getMode();

		$repository = $this->getRepository();


		$url_segments = $repository->getRequest()->segments();

		
		$last_segment = array_pop($url_segments);

		//if last segment isent create or edit
		//we check for the segmet before the last one
		if (!($last_segment==='create' or $last_segment==='edit')and count($url_segments)>1){
			$last_segment=$url_segments[count($url_segments)-1];
		}

		//dd($url_segments,$last_segment);

		if ($last_segment === 'create') {
			$mode_to_return = 'create';
		} else if ($last_segment === 'edit' ) {
			$edit_mode_permission = $this->getScreenModePerm('edit');
			$view_mode_permission = $this->getScreenModePerm('view');

			if (!empty($view_mode_permission) and $this->userHasPermission($view_mode_permission)) {
				$mode_to_return = 'view';
			}
			if (!empty($edit_mode_permission) and $this->userHasPermission($edit_mode_permission)) {
				$mode_to_return = 'edit';
			}

		}


		return $mode_to_return;
	}

	public function detectSetGetScreenMode(){
		return $this->setMode($this->detectScreenModeLayout())->getMode();
	}

	public function __construct( ? KlorchidRepositoryInterface $repository = null) {
		parent::__construct($repository);

		$this->setScreenModePerms();
	
		//$this->setScreenModePerms($this->screenModePerms());

	}

	public function layout() : array{
        
		//$this->setMode($this->detectScreenModeLayout());
		return parent::layout();
	}


	public function save(Request $request){
    	$repository = $this->getRepository();

        $mode = $this->detectSetGetScreenMode(true);
        $item = $repository->getModel();
        
        return $this->runRepositoryAction($mode,$request,true);
    }


	abstract public function screenModePerms(): array;
	abstract public function defaultModeLayout(): array;
	abstract public function viewModeLayout(): array;
	abstract public function editModeLayout(): array;
	abstract public function createModeLayout(): array;




}