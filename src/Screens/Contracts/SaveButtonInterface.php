<?php


namespace Kamansoft\Klorchid\Screens\Contracts;

use Kamansoft\Klorchid\Screens\Traits\SaveButtonTrait;
use Orchid\Screen\Actions\Button;
interface SaveButtonInterface
{

    /**
     * @return bool
     */
    public function isEnableSaveButton(): bool;

    /**
     * @param bool $enable_save_button
     * @return SaveButtonTrait
     */
    public function setEnableSaveButton(bool $enable_save_button): self;

    public function getSaveButton(): Button;

    public function setSaveButton(?Button $save_button=null): self;

    public function saveButton(): Button;
}