<?php

namespace Kamansoft\Klorchid\Screens;

use Kamansoft\Klorchid\Screens\Traits\KlorchidScreensStatusSetTrait;

abstract class KlorchidCrudScreen extends KlorchidMultiModeScreen
{
    use KlorchidScreensStatusSetTrait;

    private bool $display_save_button = true;

    public function getDisplaySaveButton()
    {
        return $this->display_save_button;
    }

    public function setDisplaySaveButton(bool $status)
    {
        $this->display_save_button = $status;
        return $this;
    }

    public function commandBar(): array
    {

        $commands = $this->curdCommandBar();



        if ($this->getDisplayStatusSetButton() and $this->getMode()!=='create' and $this->userHasActionPermission('status_set')) {
            array_push($commands, $this->statusSetButton());
        }
        if ($this->display_save_button == true and $this->userHasActionPermission($this->getMode())) {
            array_push($commands, $this->saveButton());
        }
        return $commands;
    }

    abstract function curdCommandBar(): array;

    /**
     * if $mode is null will try to guess the mode, then set it
     *
     * {@inheritdoc}
     * @see \Kamansoft\Klorchid\Screens\KlorchidMultiModeScreen::setMode()
     */
    public function setMode(?string $mode = null): self
    {
        if (is_null($mode)) {
            $mode = $this->detectScreenModeLayout();
        }
        return parent::setMode($mode);
    }

    public function detectScreenModeLayout(): string
    {
        $mode_to_return = $this->getMode();

        $repository = $this->getRepository();

        $url_segments = $repository->getRequest()->segments();

        $last_segment = array_pop($url_segments);

        // if last segment isent create or edit
        // we check for the segmet before the last one
        if (!($last_segment === 'create' or $last_segment === 'edit') and count($url_segments) > 1) {
            $last_segment = $url_segments[count($url_segments) - 1];
        }

        // dd($url_segments,$last_segment);

        if ($last_segment === 'create') {
            $mode_to_return = 'create';
        } else if ($last_segment === 'edit') {
            $edit_mode_permission = $this->getActionPerm('edit');
            $view_mode_permission = $this->getActionPerm('view');

            if (!empty($view_mode_permission) and $this->userHasPermission($view_mode_permission)) {
                $mode_to_return = 'view';
            }
            if (!empty($edit_mode_permission) and $this->userHasPermission($edit_mode_permission)) {
                $mode_to_return = 'edit';
            }
        }

        return $mode_to_return;
    }

    public function layout(): array
    {
        $mode_layout = parent::layout(); // TODO: Change the autogenerated stub
        if ($this->getDisplayStatusSetButton() and $this->userHasActionPermission('status_set')) {
            array_push($mode_layout, $this->statusSetModal());
        }
        return $mode_layout;
    }

    abstract public function defaultModeLayout(): array;

    abstract public function viewModeLayout(): array;

    abstract public function editModeLayout(): array;

    abstract public function createModeLayout(): array;


}