<?php


namespace Kamansoft\Klorchid\Screens\Traits;


use Illuminate\Http\Request;

use Orchid\Screen\Actions\Button;

trait SaveButtonTrait
{

    public bool $enable_save_button=true;
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
     * @return SaveButtonTrait
     */
    public function setEnableSaveButton(bool $enable_save_button): self
    {
        $this->enable_save_button = $enable_save_button;
        return $this;
    }



    public function getSaveButton(): Button
    {
        return $this->save_button;
    }


    public function setSaveButton(?Button $save_button=null): self
    {
        $this->save_button = $save_button ?: $this->saveButton();
        return $this;
    }

    public function saveButton(): Button
    {
        /*
        if (!method_exists($this,store)){
            throw new \Exception()
        }*/
        return Button::make(__("Save"))
            ->icon('save')
            ->method("store")
            ->confirm("Update Record");
        /*
        return Button ::make(__("Save"))
            ->method("save")
            ->canSee($can_see)
            ->icon("save");*/
    }


}

