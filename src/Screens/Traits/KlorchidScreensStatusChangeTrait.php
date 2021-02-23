<?php

use Kamansoft\Klorchid\Layouts\StatusSetFormLayout;

class KlorchidScreensStatusChangeTrait
{
    private bool $set_status_set_button = true;

    public function setStatusSetButton()
    {
        $this->set_status_set_button = true;
        return $this;
    }

    public function unsetStatusSetButton()
    {
        $this->set_status_set_button = false;
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
        $this->status_change_modal = $modal;
        return $this;
    }






}