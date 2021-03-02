<?php

namespace Kamansoft\Klorchid\Screens\Traits;

use Kamansoft\Klorchid\Layouts\StatusSetFormLayout;
use Orchid\Screen\Layouts\Modal;
use Orchid\Screen\Actions\ModalToggle;

trait KlorchidScreensStatusChangeTrait
{
    private bool $display_status_set_button = true;

    public function getDisplayStatusSetButton()
    {
        return $this->display_status_set_button;
    }

    public function setDisplayStatusSetButton(bool $status)
    {
        $this->display_status_set_button = $status;
        return $this;
    }

    public function statusSetModal()
    {
        $modal = new Modal('status-set-modal', [
            StatusSetFormLayout::class
        ]);
        $modal->title(__('Are you sure to set a new Status ?'))
            ->applyButton(__('Change'))
            ->closeButton(__('Cancel'));

        return $modal;
    }

    public function statusSetButton()
    {

        return ModalToggle::make(__('Status Set'))
            ->modal('status-set-modal')
            ->method('statusSetAction')
            //->canSee($can_see)
            //->class($this->status ? 'btn btn-success' : 'btn btn-danger')
            ->icon('check');
    }


}