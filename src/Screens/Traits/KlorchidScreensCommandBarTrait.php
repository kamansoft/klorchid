<?php


namespace Kamansoft\Klorchid\Screens\Traits;

use Illuminate\Support\Facades\Log;
use Kamansoft\Klorchid\Traits\KlorchidPermissionsTrait;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Screen;
use Kamansoft\Klorchid\Screens\Contracts\KlorchidScreensCommandBarInterface;
use Kamansoft\Klorchid\Traits\KlorchidMultiModeTrait;
use Kamansoft\Klorchid\Screens\Traits\KlorchidScreensPermissionsTrait;
use Kamansoft\Klorchid\Screens\Contracts\SaveButtonInterface;
use Kamansoft\Klorchid\Screens\Contracts\KlorchidScreensPermissionsInterface;
use Illuminate\Support\Collection;

/**
 * Trait KlorchidScreensCommandBarInterface
 * @method  KlorchidMultiModeTrait getMode()
 * @method  KlorchidScreensCommandBarInterface commandBarElements()
 * @package Kamansoft\Klorchid\Screens\Traits
 */
trait KlorchidScreensCommandBarTrait
{
    use KlorchidPermissionsTrait;

    private Collection $elements;

    public function addSaveButton()
    {
        if (empty($this->save_button)) {
            $this->setSaveButton()
                ->getSaveButton()
                ->canSee(
                    $this->loggedUserHasActionPermission('edit') or
                    $this->loggedUserHasPermission('create')
                );

        }
        $this->elements->add($this->getSaveButton());
        return $this;

    }


    public function commandBar(): array
    {
        //initiating elements collection
        $this->elements = collect([]);

        $this->elements = collect($this->commandBarElements());
        //$this->elements->add(...$this->commandBarElements());

        try {
            if ($this->isEnableSaveButton() == true) {
                $this->addSaveButton();
            }
        } catch (\Exception $exception) {
            Log::warning($exception->getMessage());
            Log::error("ScreensCommandBarTrait needs the Screen to implement: " . SaveButtonInterface::class . ' and ' . KlorchidScreensPermissionsInterface::class);
        }


        $this->commandBarCheck();

        return $this->elements->toArray();

    }

    public function commandBarCheck(): self
    {
        collect($this->elements)->map(function ($action) {
            if (!method_exists($this, $action->get('method'))) {
                throw new \Exception("The command bar of some Klorchid Screen has a button named: \"" . $action->get('name') . "\" with a method (\"" . $action->get('method') . "\") attribute that is not implemented (do not exists) on that screen class  ");

            }
        });
        return $this;
    }


}