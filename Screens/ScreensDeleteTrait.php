<?php


namespace Kamansoft\Klorchid\Screens;

use Kamansoft\Klorchid\Layouts\DeleteConfirmationFormLayout;
use Orchid\Screen\Layouts\Modal;
use Illuminate\Database\Eloquent\Model;
use Orchid\Screen\Actions\ModalToggle;
use Illuminate\Support\Facades\Auth;
use Orchid\Support\Facades\Alert;
use Illuminate\Http\Request;

trait ScreensDeleteTrait
{

    public ?Modal $delete_modal = null;

    public function setDeleteModal()
    {
        $modal = new Modal('delete-modal', [
            DeleteConfirmationFormLayout::class
        ]);

        $modal->title(__('Are you sure to Delete ?'))
            ->applyButton(__('Delete'))
            ->closeButton(__('Cancel'));
        $this->delete_modal = $modal;
        return $this;
    }

    public function getDeleteModal(): Modal
    {

        if (is_null($this->delete_modal)) {
            $this->setDeleteModal();
        }

        return $this->delete_modal;
    }


    public function getDeleteActionBtn()
    {
        $can_see  =Auth::user()->hasAccess($this->permissions_group . '.delete') and $this->action != 'create';
        \Debugbar::info("delete action btn");
        \Debugbar::info($can_see);
        return ModalToggle::make(__('Delete'))
            ->modal('delete-modal')
            ->method('delete')
            ->canSee($can_see)
            ->class('btn btn-danger')
            ->icon('icon-cross');
    }


    protected function _delete(Model $model, Request $request,?String $field = null)
    {
        if (!$this->hasPermission($this->permissions_group . '.delete')) {
            $this->setPermissionErrorAlert($this->name, 'Delete');
            return back();
        }
        $this->deleteValidate($model, $request,$field);

        try {
            $model->delete();
            Alert::success(__("Success on :action :object ", [
                "object" => __($model->key),
                "action" => __('Delete'),
            ]));
        } catch (\Exception $e) {
            Alert::error(__("Can't :action  :object", [
                    "object" => __($model->key),
                    "action" => __('Delete'),
                ]) . '<br><br>');
            Log::error('cant delete: ' . $model->key);
            Log::error($e->getMessage() . '');
        }



        return redirect()->route($this->routes_group.'.list');;
    }



    public function deleteValidate(Model $model, Request $request,?String $field = null ){
        return $this->validateWith($model->getDeleteValidationRules($field), $request);
    }

}