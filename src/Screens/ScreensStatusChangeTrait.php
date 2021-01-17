<?php


namespace Kamansoft\Klorchid\Screens;


use Kamansoft\Klorchid\Layouts\StatusInvalidateFormLayout;
use Orchid\Screen\Layout;
use Orchid\Screen\Actions\ModalToggle;
use Kamansoft\Klorchid\Layouts\StatusToggleFormLayout;
use Kamansoft\Klorchid\Layouts\StatusSetFormLayout;
use Orchid\Screen\Layouts\Modal;
use Illuminate\Support\Facades\Auth;
use Orchid\Support\Facades\Alert;
use Orchid\Screen\Actions\Link;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Http\Request;

trait ScreensStatusChangeTrait
{


    public ?Modal $status_change_modal = null;
    public ?Modal $invalidate_modal = null;


    public function setStatusSetModal()
    {
        $modal = new Modal('statusset-modal', [
            StatusSetFormLayout::class
        ]);
        $modal->title(__('Are you sure to set a new Status ?'))
            ->applyButton(__('Change'))
            ->closeButton(__('Cancel'));
        $this->status_change_modal = $modal;
        return $this;
    }

    public function getStatusSetModal(): Modal
    {
        if (is_null($this->status_change_modal)) {
            $this->setStatusSetModal();
        }
        return $this->status_change_modal;
    }

    public function getStatusSetActionBtn()
    {
        $can_see = Auth::user()->hasAccess($this->permissions_group . '.statuschange') and $this->action == 'edit';
        //$can_see = Auth::user()->hasAccess($this->permissions_group . '.statuschange') ;

        return ModalToggle::make(__('Status Set'))
            ->modal('statusset-modal')
            ->method('statusSet')
            ->canSee($can_see)
        //->class($this->status ? 'btn btn-success' : 'btn btn-danger')
            ->icon('icon-check');
    }


    public function setStatusToggleModal()
    {
        $modal = new Modal('statustoggle-modal', [
            StatusToggleFormLayout::class
        ]);

        $modal->title(__('Are you sure to toggle Status ?'))
            ->applyButton(__('Toggle'))
            ->closeButton(__('Cancel'));
        $this->status_change_modal = $modal;
        return $this;
    }

    public function getStatusToggleModal(): Modal
    {
        if (is_null($this->status_change_modal)) {
            $this->setStatusToggleModal();
        }
        return $this->status_change_modal;
    }

    public function getStatusToggleActionBtn()
    {
        $can_see = (Auth::user()->hasAccess($this->permissions_group . '.statuschange') and $this->action !== 'create') ;

        return ModalToggle::make(__('Status Toggle'))
            ->modal('statustoggle-modal')
            ->method('statusToggle')
            ->canSee($can_see)
            ->class($this->status ? 'btn btn-danger' : 'btn btn-success')
            ->icon('icon-power');
    }


    public function setInvalidateModal()
    {
        $modal = new Modal('invalidate-modal', [
            StatusInvalidateFormLayout::class
        ]);

        $modal->title(__('Are you sure to invalidate current element ?'))
            ->applyButton(__('Invalidate'))
            ->closeButton(__('Cancel'));
        $this->invalidate_modal = $modal;
        return $this;
    }


    public function getInvalidateModal(): Modal
    {

        if (is_null($this->invalidate_modal)) {
            $this->setInvalidateModal();
        }

        return $this->invalidate_modal;
    }

    public function getInvalidateActionBtn()
    {
        return ModalToggle::make(__('Invalidate'))
            ->modal('invalidate-modal')
            ->method('invalidate')
            ->class('btn btn-danger')
            ->canSee(
                Auth::user()->hasAccess($this->permissions_group . '.invalidate') and
                /*!(
                    Auth::user()->hasAccess($this->permissions_group . '.invalidate') and
                    Auth::user()->hasAccess($this->permissions_group . '.statuschange')
                )and */
                $this->action !== 'create' and
                $this->model->status

            )
            ->icon('icon-cross');
    }


    public function statusSetValidate(Model $model, Request $request)
    {
        return $this->validateWith($model->getStatusSetValidationRules($request), $request);
    }
    public function statusToggleValidate(Model $model, Request $request){
        return $this->validateWith($model->getStatusToggleValidationRules($request), $request);
    }
    public function invalidateValidate(Model $model, Request $request){
        return $this->validateWith($model->getStatusToggleValidationRules($request), $request);
    }

    protected function _statusSet(Model $model, Request $request)
    {
        $validation = $this->statusSetValidate($model, $request);

        $action = 'Status Change';
        try {

            $model->statusSet($validation['element']['new_status'], $validation['element']['new_status_reason']);
            Alert::success(__("Success on :action :object ", [
                "object" => __($this->name),
                "action" => __($action),
            ]));
        } catch (\Illuminate\Database\QueryException $e) {
            Alert::error(__("Can't :action  :object", [
                    "object" => __($this->name),
                    "action" => __($action),
                ]) . '<br><br>');
            Log::error('cant Change Status: ' . $this->name);
            Log::error($e->getMessage() . '');
        }
        //return "cabiando";
        return back();
    }

    protected function _statusToggle(Model $model, Request $request)
    {
        $validation = $this->statusToggleValidate($model, $request);
        //\DeBugbaR::info($validation);
        $action = 'Status Toggle';
        try {

            $model->statusToggle($validation['element']['new_status_reason']);
            Alert::success(__("Success on :action :object ", [
                "object" => __($this->name),
                "action" => __($action),
            ]));
        } catch (\Illuminate\Database\QueryException $e) {
            Alert::error(__("Can't :action  :object", [
                    "object" => __($this->name),
                    "action" => __($action),
                ]) . '<br><br>');
            Log::error('cant toggle status : ' . $this->name);
            Log::error($e->getMessage() . '');
        }
        return back();

    }

    protected function _invalidate(Model $model, Request $request)
    {
        $this->invalidateValidate($model, $request);
        $action = 'Invalidate';
        try {

            $model->invalidate();
            Alert::success(__("Success on :action :object ", [
                "object" => __($this->name),
                "action" => __($action),
            ]));
        } catch (\Illuminate\Database\QueryException $e) {
            Alert::error(__("Can't :action  :object", [
                    "object" => __($this->name),
                    "action" => __($action),
                ]) . '<br><br>');
            Log::error('cant invalidate : ' . $this->name);
            Log::error($e->getMessage() . '');
        }
        return back();

    }


}
