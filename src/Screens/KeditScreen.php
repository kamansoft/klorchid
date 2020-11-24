<?php

namespace Kamansoft\Klorchid\Screens;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Route;
use Kamansoft\Klorchid\Screens\Actions\ConfirmationButon;
use Kamansoft\Klorchid\Screens\ScreensDeleteTrait;
use Kamansoft\Klorchid\Screens\ScreensPermissionsTrait;
use Kamansoft\Klorchid\Screens\ScreensStatusChangeTrait;
use Orchid\Screen\Action;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Layout;
use Orchid\Screen\Screen;

abstract class KeditScreen extends Screen {

	use ScreensPermissionsTrait;
	use ScreensStatusChangeTrait;
	use ScreensDeleteTrait;

	private Collection $_dashboard_permissions_list;
	public $permissions_group = null;
	protected string $action = 'view';
	protected bool $active = false;
	protected $model = null;

	protected $status = false;

	protected $routes_group = '';

	public function __construct(Request $request = null) {

		//parent::__construct($request);
		$this->_dashboard_permissions_list = $this->getDasboardPermissions();
	}

	public function getListActionBtn() {
		return Link::make(__('List'))
			->route($this->routes_group . '.list')
			->canSee($this->hasPermission('app_setting.list'))
			->icon('icon-list');
	}

	public function commandBar(): array
	{

		$to_return = [];

		\Debugbar::info($this->routes_group . '.list');
		\Debugbar::info(Route::has($this->routes_group . '.list'));

		if (Route::has($this->routes_group . '.list')) {
			array_push($to_return, $this->getListActionBtn());
		}

		if ($this->action !== 'create') {
			if (method_exists($this, 'statusSet')) {
				\DebugBar::info('has statusSet method');
				array_push($to_return, $this->getStatusSetActionBtn());
			} elseif (method_exists($this, 'statusToggle')) {
				\DebugBar::info('has statusToggle method');
				array_push($to_return, $this->getStatusToggleActionBtn());
			} elseif (method_exists($this, 'invalidate')) {
				\DebugBar::info('has invalidate method');
				array_push($to_return, $this->getInvalidateActionBtn());
			}
		}

		array_push($to_return, ...$this->keditCommandBar());

		if (method_exists($this, 'delete')) {
			\DebugBar::info('has delete method');
			array_push($to_return, $this->getDeleteActionBtn());
		}
		if (method_exists($this, 'save')) {
			\DebugBar::info('has save method');
			$save_btn = ConfirmationButon::make(__('Save'))
				->icon('icon-check')
				->method('save')
				->novalidate(false)
				->canSee(
					$this->action == 'create'
					or $this->action == 'edit'
				);
			array_push($to_return, $save_btn);
		}

		return $to_return;
	}

	public function layout(): array
	{
		$layouts = $this->keditLayout();
		if (method_exists($this, 'delete')) {
			array_push($layouts, $this->getDeleteModal());
		}

		if ($this->action !== 'create') {
			if (method_exists($this, 'statusSet')) {
				\DebugBar::info('has statusSet method');
				array_push($layouts, $this->getStatusSetModal());
			} elseif (method_exists($this, 'statusToggle')) {
				\DebugBar::info('has statusToggle method');
				array_push($layouts, $this->getStatusToggleModal());
			} elseif (method_exists($this, 'invalidate')) {
				\DebugBar::info('has invalidate method');
				array_push($layouts, $this->getInvalidateModal());
			}
		}

		return $layouts;
	}
	/**
	 * Button commands (status change buttons will be prepended)
	 * and save button will be appended to all elements on the
	 * returned array of this method, the save button will only appear
	 * if the method save is implemented in this constructor class.
	 *
	 * @return Action[]
	 */
	abstract public function keditCommandBar(): array;

	/**
	 * Views.
	 * Status change modal will be appended
	 *
	 * @return Layout[]
	 */
	abstract public function keditLayout(): array;

	public function validateOnCreate(Model $model, Request $request) {
		return $this->validateWith($model->getCreateValidationRules($request));
	}

	public function validateOnEdit(Model $model, Request $request) {
		return $this->validateWith($model->getEditValidationRules($request));
	}

}
