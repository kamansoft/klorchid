<?php


namespace Kamansoft\Klorchid\Screens\Traits;


use Illuminate\Http\Request;

use Kamansoft\Klorchid\Traits\KlorchidPermissionsTrait;
use Orchid\Screen\Actions\Button;

trait DeleteCommandTrait
{


    public bool $enable_delete_button = true;
    public Button $delete_button;

    /**
     * @return bool
     */
    public function isEnableDeleteButton(): bool
    {
        return $this->enable_delete_button;
    }

    /**
     * @param bool $enable_delete_button
     * @return DeleteCommandTrait
     */
    public function setEnableDeleteButton(bool $enable_delete_button): self
    {
        $this->enable_delete_button = $enable_delete_button;
        return $this;
    }


    public function getDeleteButton(): Button
    {
        return $this->initDeleteButton()->delete_button;
    }

    public function initDeleteButton(?Button $delete_button = null): self
    {
        if (!isset($this->delete_button)) {
            $this->setDeleteButton(is_null($delete_button) ? $this->deleteButton() : $delete_button);
        }
        return $this;
    }

    public function setDeleteButton(Button $delete_button): self
    {
        $this->delete_button = $delete_button;
        return $this;
    }


    public function deleteButton(): Button
    {

        return Button::make(__("Delete"))
            ->icon('cross')
            ->method("delete")
            ->confirm(__("You are abobut to delete this entry."));

    }


}

