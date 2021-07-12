<?php


namespace Kamansoft\Klorchid\Screens\Traits;

use Illuminate\Support\Facades\Log;
use Kamansoft\Klorchid\Layouts\StatusChangeCommandModalFormLayout;
use Kamansoft\Klorchid\Layouts\Traits\StatusFieldsTrait;
use Kamansoft\Klorchid\Models\KlorchidMultiStatusModel;
use Kamansoft\Klorchid\Screens\KlorchidCrudScreen;
use Kamansoft\Klorchid\Traits\KlorchidPermissionsTrait;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Actions\Link;
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
 * @method  array commandBarElements()
 * @property array $actionRouteNames
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

            $this->setCommandBarElements(is_null($elements) ? [] : $elements);
        }
        $child_elements = $this->commandBarElements();

        if (!empty($child_elements)) {
            $this->getCommandBarElements()->prepend(...$child_elements);
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
        return $this->command_bar_elements;
    }


    public function commandBar(): array
    {

        $this->initCommandBarElements();

        /*
        dd(
            $this->getMode() !== self::COLLECTION_MODE and
            property_exists($this, 'actionRouteNames') and
            is_array($this->actionRouteNames) and
            array_key_exists(self::COLLECTION_MODE, $this->actionRouteNames)
        );*/


        if ($this->getMode() !== self::COLLECTION_MODE and
            property_exists($this, 'actionRouteNames') and
            is_array($this->actionRouteNames) and
            array_key_exists(self::COLLECTION_MODE, $this->actionRouteNames)) {
            $this->getCommandBarElements()->add(
                Link::make(__('List'))
                    ->route($this->actionRouteNames[self::COLLECTION_MODE])
                    ->icon('list')
            );
        }

        $mode = $this->getMode();
        if (
            $this->isEnableStatusChangeButton() == true and
            $mode !== KlorchidCrudScreen::COLLECTION_MODE and
            $mode !== KlorchidCrudScreen::CREATE_MODE
        ) {
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

        if ($this->isEnableSaveButton() == true and $mode !== KlorchidCrudScreen::COLLECTION_MODE) {
            $this->getCommandBarElements()->add($this->getSaveButton());
        }


        $this->commandBarCheck();

        return $this->getCommandBarElements()->toArray();

    }


    /**
     * Makes sure exists all the methos name as attributte of each action if exists
     * @return $this
     */
    public function commandBarCheck(): self
    {
        collect($this->command_bar_elements)->map(function ($action) {

            // TODO: change the way links actions are detected  as they do not use screen methods
            if (
                !is_null($action->get('method')) and
                $action->isSee() and
                !method_exists($this, $action->get('method'))
            ) {
                throw new \Exception("The command bar of some Klorchid Screen has a action element named: \"" . $action->get('name') . "\" with a method attribute name set to (\"" . $action->get('method') . "\"). Method name is not implemented (do not exists) on " . self::class . " instance");
            }
        });
        return $this;
    }


}