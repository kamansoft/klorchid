<?php


namespace Kamansoft\Klorchid\Screens\Traits;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Kamansoft\Klorchid\Http\Request\KlorchidStatusChangeFormRequest;
use Kamansoft\Klorchid\Layouts\StatusChangeCommandModalFormLayout;
use Kamansoft\Klorchid\Models\KlorchidEloquentModel;
use Kamansoft\Klorchid\Models\KlorchidMultiStatusModel;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Actions\ModalToggle;https://towardsdatascience.com/top-10-in-demand-web-development-frameworks-in-2021-8a5b668be0d6
use Orchid\Support\Facades\Layout;

trait StatusChangeCommandTrait
{

    static string $status_change_modal_name = 'status-change-modal';

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


    public function getStatusChangeButton(Collection $layout_elements,array $status_set_modal_layout_options): Button
    {
        return $this->initStatusChangeButton($layout_elements,$status_set_modal_layout_options)->status_change_button;
    }

    public function initStatusChangeButton(
        Collection $layout_elements,
        array $status_set_modal_layout_options,
        ?Button $status_change_button = null): self
    {

        if (!isset($this->status_change_button)) {
            $this->setStatusChangeButton(
                $layout_elements,
                $status_set_modal_layout_options,
                is_null($status_change_button) ? $this->statusChangeButton() : $status_change_button);
        }
        return $this;
    }

    public function setStatusChangeButton(
        Collection $layout_elements,
        array $status_set_modal_layout_options,
        Button $status_change_button): self
    {
//      $layout_elements->add($this->statusChangeModalForm($status_set_modal_layout_options));
        $this->status_change_button = $status_change_button;
        return $this;
    }


   public function statusChangeModalLayout(): \Orchid\Screen\Layouts\Modal
   {
        return Layout::modal(self::$status_change_modal_name,StatusChangeCommandModalFormLayout::class);
   }


    public function statusChangeButton(): Button
    {

        return ModalToggle::make(__('Status Change'))
            ->modal(self::$status_change_modal_name)
            ->method('statusChange')
            ->icon('power');

    }





}