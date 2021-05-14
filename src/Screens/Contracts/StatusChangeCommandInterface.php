<?php


namespace Kamansoft\Klorchid\Screens\Contracts;

use Illuminate\Support\Collection;
use Orchid\Screen\Actions\Button;
interface StatusChangeCommandInterface
{

    /**
     * @return bool
     */
    public function isEnableStatusChangeButton(): bool;

    public function setEnableStatusChangeButton(bool $enable_status_change_button): self;

    public function getStatusChangeButton(Collection $layout_elements, array $status_set_modal_layout_options): Button;

    public function initStatusChangeButton(
        Collection $layout_elements,
        array $status_set_modal_layout_options,
        ?Button $status_change_button = null): self;

    public function setStatusChangeButton(
        Collection $layout_elements,
        array $status_set_modal_layout_options,
        Button $status_change_button): self;

    public function statusChangeModalLayout(): \Orchid\Screen\Layouts\Modal;

    public function statusChangeButton(): Button;
}