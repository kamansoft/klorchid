<?php


namespace Kamansoft\Klorchid\Screens\Contracts;

use Kamansoft\Klorchid\Screens\Traits\SaveCommandTrait;
use Orchid\Screen\Actions\Button;

interface SaveCommandInterface
{

    public function isEnableSaveButton(): bool;

    public function setEnableSaveButton(bool $enable_save_button): self;


    public function getSaveButton(): Button;

    public function initSaveButton(?Button $save_button = null): self;

    public function setSaveButton(Button $save_button): self;

    public function saveButton(): Button;
}