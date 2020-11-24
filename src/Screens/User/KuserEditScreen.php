<?php

namespace Kamansoft\klorchid\Screens\User;

use App\Orchid\Layouts\Role\RolePermissionLayout;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Kamansoft\Klorchid\Layouts\User\KuserCreateLayout;
use Kamansoft\Klorchid\Layouts\User\KuserEditLayout;
use Kamansoft\Klorchid\Layouts\User\KuserRoleLayout;
use Kamansoft\Klorchid\Models\Kuser;
use Kamansoft\Klorchid\Screens\KeditScreen;
use Orchid\Screen\Action;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Alert;

class KuserEditScreen extends KeditScreen {

	/**
	 * Display header name.
	 *
	 * @var string
	 */
	public $name = 'KuserEditScreenb';

	/**
	 * Display header description.
	 *
	 * @var string
	 */
	public $description = 'KuserEditScreenb';

	/**
	 * Set the permition group where the actions of this screen module belongs
	 *
	 * @var string
	 */
	public $permissions_group = 'platform.systems.users';

	/**
	 * @var string
	 */
	public $permission = [
		'platform.systems.users',
		'platform.systems.users.edit',
		'platform.systems.users.add',
		'platform.systems.users.delete',
		'platform.systems.users.invalidate',
		'platform.systems.users.statuschange',
	];

	public bool $exists = false;

	/**
	 * Query data.
	 *
	 * @return array
	 */
	public function query(Kuser $model): array
	{
		$this->action = $this->formFunctionality($model);
		\Debugbar::info($this->action);
		\Debugbar::info("Kuser editscreen action");
		$this->model = &$model;
		$this->exists = $this->model->exists;
		$this->status = $this->model->status;

		$model->load(['roles']);

		return [
			'delete_confirmation_attribute_name' => 'element.id',
			'form_action' => $this->action,
			'element' => $model,
			'permission' => $model->getStatusPermission(),
		];
	}

	/**
	 * Button commands (status change buttons will be prepended)
	 * and save button will be appended to all elements on the
	 * returned array of this method, the save button will appear
	 * only if the method save is implemented in this constructor.
	 *
	 * @return Action[]
	 */
	public function keditCommandBar(): array
	{
		return [
			Button::make(__('Login as user'))
				->icon('login')
				->method('loginAs'),

		];
	}

	/*
		                    public function invalidate(Currency $model, Request $request){
		                        return $this->_invalidate($model,$request);

	*/

	public function statusToggle(Kuser $model, Request $request) {
		return $this->_statusToggle($model, $request);
	}

	public function delete(Kuser $model, Request $request) {
		return $this->_delete($model, $request);
	}

	/*
		                    public function statusSet(Currency $model, Request $request)
		                    {
		                        return $this->_statusSet($model, $request);
	*/

	public function save(Kuser $model, Request $request) {
		//chancge the Kuser Type by the one relate to screen
		$action = $this->formFunctionality($model);

		$validation = [];
		if ($action == 'create') {
			$validation = $this->validateOnCreate($model, $request);
		} elseif ($action == 'edit') {
			$validation = $this->validateOnEdit($model, $request);
		} else {
			Alert::error(__("You have not :object :permission permission", [
				"object" => __($this->name),
				"permission" => __("save"),
			]));
			return back();
		}
		try {

			$permissions = collect($request->get('permissions'))
				->map(function ($value, $key) {
					return [base64_decode($key) => $value];
				})
				->collapse()
				->toArray();
			$model
				->fill($validation['element'])
				->replaceRoles($request->input('element.roles'))
				->fill([
					'permissions' => $permissions,
				])
				->save();

			$model->save();
			Alert::success(__("Success on :action :object ", [
				"object" => __($this->name),
				"action" => __($action),
			]));
		} catch (\Exception $e) {
			Alert::error(__("Can't :action  :object", [
				"object" => __($this->name),
				"action" => __($action),
			]) . '<br><br>');
			Log::error('cant save: ' . $this->name);
			Log::error($e->getMessage() . '');
		}
		return back();
	}

	/**
	 * Views.
	 *
	 * Status change modal will be appended
	 *
	 * @return Layout[]
	 */
	public function keditLayout(): array
	{

		$main_form_layout_class = ($this->action == 'create') ? KuserCreateLayout::class : KuserEditLayout::class;
		return [
			$main_form_layout_class,
			KuserRoleLayout::class,
			RolePermissionLayout::class,
		];
	}
}
