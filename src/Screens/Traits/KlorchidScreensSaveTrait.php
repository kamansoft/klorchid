<?php


namespace Kamansoft\Klorchid\Screens\Traits;


use Illuminate\Http\Request;
use Kamansoft\Klorchid\Screens\Actions\ConfirmationButton;
use Orchid\Screen\Actions\Button;

trait KlorchidScreensSaveTrait
{

    public bool $enable_save_button;
    public ConfirmationButton $save_button;

    /**
     * @return bool
     */
    public function isEnableSaveButton(): bool
    {
        return $this->enable_save_button;
    }

    /**
     * @param bool $enable_save_button
     * @return KlorchidScreensSaveTrait
     */
    public function setEnableSaveButton(bool $enable_save_button): KlorchidScreensSaveTrait
    {
        $this->enable_save_button = $enable_save_button;
        return $this;
    }


    /**
     * @return \Kamansoft\Klorchid\Screens\Actions\ConfirmationButton
     */
    public function getSaveButton(): ConfirmationButton
    {
        return $this->save_button;
    }

    /**
     * @param \Kamansoft\Klorchid\Screens\Actions\ConfirmationButton $save_button
     * @return KlorchidScreensSaveTrait
     */
    public function setSaveButton(ConfirmationButton $save_button): KlorchidScreensSaveTrait
    {
        $this->save_button = $save_button ?: $this->saveButton();
        return $this;
    }

    public function saveButton(bool $can_see = true): Button
    {
        return Button::make(__("save"))
            ->method("store")
            ->confirm("Update Record");
        /*
        return ConfirmationButton::make(__("Save"))
            ->method("save")
            ->canSee($can_see)
            ->icon("save");*/
    }


}

