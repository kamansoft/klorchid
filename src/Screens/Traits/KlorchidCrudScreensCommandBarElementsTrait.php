<?php


namespace Kamansoft\Klorchid\Screens\Traits;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;
use Kamansoft\Klorchid\Layouts\Traits\StatusFieldsTrait;
use Kamansoft\Klorchid\Models\KlorchidMultiStatusModel;
use Kamansoft\Klorchid\Screens\KlorchidCrudScreen;
use Kamansoft\Klorchid\Traits\KlorchidPermissionsTrait;
use Orchid\Screen\Actions\Link;

/**
 * Trait KlorchidScreensCommandBarElementsInterface
 * @method  string getMode()
 * @package Kamansoft\Klorchid\Screens\Traits
 */
trait KlorchidCrudScreensCommandBarElementsTrait
{
    use SaveCommandTrait;
    use StatusFieldsTrait;
    use StatusChangeCommandTrait;
    use KlorchidPermissionsTrait;
    use DeleteCommandTrait;


    public KlorchidMultiStatusModel $model;
    private Collection $command_bar_elements;

    public function commandBar(): array
    {

        $this->initCommandBarElements();

        if ($this->getMode() == self::COLLECTION_MODE) {
            $this->getCommandBarElements()
                ->add(Link::make(__("Add"))
                    ->icon('add')
                    //->canSee($this->getMode() === self::COLLECTION_MODE)
                    ->route($this->getRouteNameFromAction(self::EDIT_MODE))
                );
        }

        try {
            if ($this->getMode() !== self::COLLECTION_MODE and $this->checkActionRoutesMapAttribute()) {
                $this->getCommandBarElements()->add(
                    Link::make(__('List'))
                        ->route($this->getRouteNameFromAction(self::COLLECTION_MODE))
                        ->icon('list')
                );
            }
        } catch (\Exception $e) {
            Log::info("List button for crud screen cant be displayed " . $e->getMessage());
        }

        $mode = $this->getMode();

        if (
            $this->isEnableStatusChangeButton() == true and
            $mode !== KlorchidCrudScreen::COLLECTION_MODE and
            $mode !== KlorchidCrudScreen::CREATE_MODE
        ) {
            if (!isset($this->model)) {
                throw new \Exception(' You must set the $model attribute with a 
                ' . KlorchidMultiStatusModel::class . ' object  prior the screen commandBar method call, you can do that at 
                the screen query method scope of ' . self::class . ' , $this->setModel($model) method is available in every ' . self::class . ' 
                class');
            }
            $this->getCommandBarElements()
                ->add(
                    $this->getStatusChangeButton(
                        $this->getLayoutElements(),
                        $this->getModel()
                            ->statusPresenter()
                            ->getOptions()
                    )->class('btn btn-link text-'.$this->getModel()->getStatusColorClass())
                );


            $this->getLayoutElements()->add(
                $this->statusChangeModalLayout()
            );


        }
        if ($this->isEnableDeleteButton() == true and $mode === KlorchidCrudScreen::EDIT_MODE) {
            $this->getCommandBarElements()->add($this->getDeleteButton());
        }
        if ($this->isEnableSaveButton() == true and $mode !== KlorchidCrudScreen::COLLECTION_MODE) {
            $this->getCommandBarElements()->add($this->getSaveButton());
        }


        $this->commandBarCheck();

        return $this->getCommandBarElements()->toArray();

    }

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

    public function getCommandBarElements(): Collection
    {
        return $this->command_bar_elements;
    }

    public function setCommandBarElements(array $elements = null): self
    {
        $this->command_bar_elements = collect($elements);
        return $this;
    }

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
                throw new \Exception(self::class . ': the command bar element named "' . $action->get('name') . "\" has it's \"method\" attribute name set to (\"" . $action->get('method') . "\"). But the a method \"" . $action->get('method') . "()\" is not implemented (do not exists) on " . static::class . ' screen');
            }
        });
        return $this;
    }


}