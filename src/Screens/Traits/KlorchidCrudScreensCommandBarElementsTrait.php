<?php


namespace Kamansoft\Klorchid\Screens\Traits;

use Illuminate\Support\Facades\Log;
use Kamansoft\Klorchid\Layouts\StatusChangeCommandModalFormLayout;
use Kamansoft\Klorchid\Layouts\Traits\StatusFieldsTrait;
use Kamansoft\Klorchid\Models\KlorchidMultiStatusModel;
use Kamansoft\Klorchid\Screens\KlorchidCurdScreen;
use Kamansoft\Klorchid\Traits\KlorchidPermissionsTrait;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Fields\Input;
use Orchid\Support\Facades\Layout;
use Orchid\Screen\Screen;
use Kamansoft\Klorchid\Screens\Contracts\KlorchidScreensCommandBarElementsInterface;
use Kamansoft\Klorchid\Traits\KlorchidMultiModeTrait;
use Kamansoft\Klorchid\Screens\Traits\KlorchidScreensPermissionsTrait;
use Kamansoft\Klorchid\Screens\Contracts\SaveCommandInterface;
use Kamansoft\Klorchid\Screens\Contracts\KlorchidScreensPermissionsInterface;
use Illuminate\Support\Collection;

/**
 * Trait KlorchidScreensCommandBarElementsInterface
 * @method  string getMode()
 * @method  KlorchidScreensCommandBarElementsInterface commandBarElements()
 * @package Kamansoft\Klorchid\Screens\Traits
 */
trait KlorchidCrudScreensCommandBarElementsTrait
{
    use SaveCommandTrait;
    use StatusFieldsTrait;
    use StatusChangeCommandTrait;
    use KlorchidPermissionsTrait;


    public KlorchidMultiStatusModel $model;

    /**
     * @return \Kamansoft\Klorchid\Models\KlorchidMultiStatusModel
     */
    public function getModel(): KlorchidMultiStatusModel
    {
        return $this->model;
    }

    /**
     * @param \Kamansoft\Klorchid\Models\KlorchidMultiStatusModel $model
     * @return KlorchidCrudScreensCommandBarElementsTrait
     */
    public function setModel(KlorchidMultiStatusModel $model): self
    {
        $this->model = $model;
        return $this;
    }

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

        $mode ='';
        if ($this->isEnableStatusChangeButton() == true and $mode!==KlorchidCurdScreen::COLLECTION_MODE) {
            if (!isset($this->model)) {
                throw new \Exception(' You must initialize the $model attribute with a 
                ' . KlorchidMultiStatusModel::class . ' object  prior the screen commandBar method call, you can do that at 
                the screen query method scope , $this->setModel($model) method is available in every ' . self::class . ' 
                class with this in mind');
            }
            $this->getCommandBarElements()
                ->add(
                    $this->getStatusChangeButton(
                        $this->getLayoutElements(),
                        $this->getModel()
                            ->statusPresenter()
                            ->getOptions()
                    )
                );


            $this->getLayoutElements()->add(


                Layout::modal(
                    self::$status_change_modal_name,
                    StatusChangeCommandModalFormLayout::class
                    /*Layout::rows(
                        array_merge(
                            $this->statusFields(
                                self::$screen_query_model_keyname,
                            ),
                            $this->newStatusFields(
                                self::$screen_query_model_keyname,
                                $this->getModel()->statusPresenter()->getOptions()
                            )
                        )
                    )*/
                )


            );
        }

        if ($this->isEnableSaveButton() == true and $mode!==KlorchidCurdScreen::COLLECTION_MODE) {
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