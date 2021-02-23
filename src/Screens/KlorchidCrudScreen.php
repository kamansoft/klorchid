<?php
namespace Kamansoft\Klorchid\Screens;

use Orchid\Screen\Layout;
use Orchid\Screen\Actions\Button;

abstract class KlorchidCrudScreen extends KlorchidMultiModeScreen {

	private bool $save_commandbar_btn = true;
	//private bool $

	public function addSaveButton() {
		$this->save_commandbar_btn = true;
	}
	public function removeSaveButton() {
		$this->save_commandbar_btn = false;
	}

	public function getSaveButtonForCrud() {
		return Button::make(__('Save'))
			->icon('check')
			->parameters([
				'repository_action' => $this->getMode(),
				'run_validation' => true,
			])
			->canSee($this->userHasScreenModePermission($this->getMode()))
			->method('runRepositoryAction');
	}

	public function detectScreenModeLayout(): string{
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
			$edit_mode_permission = $this->getScreenModePerm('edit');
			$view_mode_permission = $this->getScreenModePerm('view');

			if (!empty($view_mode_permission) and $this->userHasPermission($view_mode_permission)) {
				$mode_to_return = 'view';
			}
			if (!empty($edit_mode_permission) and $this->userHasPermission($edit_mode_permission)) {
				$mode_to_return = 'edit';
			}
		}

		return $mode_to_return;
	}

	/**
	 * if $mode is null will try to guess the mode, then set it
	 *
	 * {@inheritdoc}
	 * @see \Kamansoft\Klorchid\Screens\KlorchidMultiModeScreen::setMode()
	 */
	public function setMode( ? string $mode = null) : self {
		if (is_null($mode)) {
			$mode = $this->detectScreenModeLayout();
		}
		return parent::setMode($mode);
	}

	public function layout(): array
	{

		// $this->setMode($this->detectScreenModeLayout());
		return parent::layout();
	}

	abstract public function defaultModeLayout(): array;

	abstract public function viewModeLayout(): array;

	abstract public function editModeLayout(): array;

	abstract public function createModeLayout(): array;
}