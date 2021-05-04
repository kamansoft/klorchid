<?php


namespace Kamansoft\Klorchid\Screens\Traits;

use Illuminate\Database\Eloquent\Model;
use Kamansoft\Klorchid\Models\KlorchidEloquentModel;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Actions\ModalToggle;

trait StatusChangeCommandTrait
{


    public bool $enable_status_change_button = true;
    public Button $status_change_button;

    /**
     * @return bool
     */
    public function isEnableStatusChangeButton(): bool
    {
        return $this->enable_status_change_button;
    }

    /**
     * @param bool $enable_status_change_button
     * @return StatusChangeCommandTrait
     */
    public function setEnableStatusChangeButton(bool $enable_status_change_button): self
    {
        $this->enable_status_change_button = $enable_status_change_button;
        return $this;
    }


    public function getStatusChangeButton(): Button
    {
        return $this->initStatusChangeButton()->status_change_button;
    }

    public function initStatusChangeButton(?Button $status_change_button = null): self
    {
        if (!isset($this->status_change_button)) {
            $this->setStatusChangeButton(is_null($status_change_button) ? $this->statusChangeButton() : $status_change_button);
        }
        return $this;
    }

    public function setStatusChangeButton(Button $status_change_button): self
    {
        $this->status_change_button = $status_change_button;
        return $this;
    }


    public function statusChangeButton(): Button
    {

        return ModalToggle::make(__('Status Change'))
            ->modal('status-change-modal')
            ->method('statusChange')
            ->icon('power');

    }

    public function statusChange(KlorchidEloquentModel $model, KlorchidStatusChangeFormRequest $request){
        return $request->satusChange($model);
    }



}