<?php


namespace Kamansoft\Klorchid\Screens\Traits;

use Illuminate\Support\Facades\Log;
use Kamansoft\Klorchid\Traits\KlorchidPermissionsTrait;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Screen;
use Kamansoft\Klorchid\Screens\Contracts\KlorchidScreensCommandBarElementsInterface;
use Kamansoft\Klorchid\Traits\KlorchidMultiModeTrait;
use Kamansoft\Klorchid\Screens\Traits\KlorchidScreensPermissionsTrait;
use Kamansoft\Klorchid\Screens\Contracts\SaveCommandInterface;
use Kamansoft\Klorchid\Screens\Contracts\KlorchidScreensPermissionsInterface;
use Illuminate\Support\Collection;

/**
 * Trait KlorchidScreensCommandBarElementsInterface
 * @method  KlorchidMultiModeTrait getMode()
 * @method  KlorchidScreensCommandBarElementsInterface commandBarElements()
 * @package Kamansoft\Klorchid\Screens\Traits
 */
trait KlorchidScreensCommandBarElementsTrait
{
    use SaveCommandTrait;
    use StatusChangeCommandTrait;
    use KlorchidPermissionsTrait;

    private Collection $command_bar_elements;


    /**
     * Initialize the $command_bar_elements collection
     * @param array|null $elements if null, the returned array from screen commandBarElements method will be used
     * @return $this
     */
    public function initCommandBarElements(array $elements = null): self
    {
        if (!isset($this->command_bar_elements)) {
            $this->setCommandBarElements(is_null($elements) ? $this->commandBarElements() : $elements);
        }
        return $this;
    }

    public function setCommandBarElements(array $elements = null): self
    {
        $this->command_bar_elements = collect($elements);
        return $this;
    }

    public function getCommandBarElements(): Collection
    {
        return $this->initCommandBarElements()->command_bar_elements;
    }


    public function commandBar(): array
    {
        $this->initCommandBarElements();


        if ($this->isEnableStatusChangeButton() == true) {
            $this->getCommandBarElements()->add($this->getStatusChangeButton());
        }

        if ($this->isEnableSaveButton() == true) {
            $this->getCommandBarElements()->add($this->getSaveButton());
        }


        $this->commandBarCheck();

        return $this->getCommandBarElements()->toArray();

    }

    public function commandBarCheck(): self
    {
        collect($this->command_bar_elements)->map(function ($action) {
            if ($action->isSee() and !method_exists($this, $action->get('method'))) {
                throw new \Exception("The command bar of some Klorchid Screen has a button named: \"" . $action->get('name') . "\" with a method attribute name set to (\"" . $action->get('method') . "\"). Method name is not implemented (do not exists) on " . self::class . " instance");

            }
        });
        return $this;
    }


}