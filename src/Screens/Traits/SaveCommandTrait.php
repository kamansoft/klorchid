<?php


namespace Kamansoft\Klorchid\Screens\Traits;


use Illuminate\Http\Request;

use Kamansoft\Klorchid\Traits\KlorchidPermissionsTrait;
use Orchid\Screen\Actions\Button;

trait SaveCommandTrait
{


    public bool $enable_save_button = true;
    public Button $save_button;

    /**
     * @return bool
     */
    public function isEnableSaveButton(): bool
    {
        return $this->enable_save_button;
    }

    /**
     * @param bool $enable_save_button
     * @return SaveCommandTrait
     */
    public function setEnableSaveButton(bool $enable_save_button): self
    {
        $this->enable_save_button = $enable_save_button;
        return $this;
    }


    public function getSaveButton(): Button
    {
        return $this->initSaveButton()->save_button;
    }

    public function initSaveButton(?Button $save_button = null): self
    {
        if (!isset($this->save_button)) {
            $this->setSaveButton(is_null($save_button) ? $this->saveButton() : $save_button);
        }
        return $this;
    }

    public function setSaveButton(Button $save_button): self
    {
        $this->save_button = $save_button;
        return $this;
    }


    public function saveButton(): Button
    {

        return Button::make(__("Save"))
            ->icon('save')
            ->method("store")
            ->confirm("Update Record");

    }


}

