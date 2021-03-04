<?php

namespace Kamansoft\Klorchid\Screens\Traits;

use Kamansoft\Klorchid\Layouts\KlorchidStatusSetFormLayout;
use Orchid\Screen\Actions\ModalToggle;
use Orchid\Screen\Layouts\Modal;

trait KlorchidScreensStatusSetTrait {
	private bool $display_status_set_button = true;

	public function getDisplayStatusSetButton() {
		return $this->display_status_set_button;
	}

	public function setDisplayStatusSetButton(bool $status) {
		$this->display_status_set_button = $status;
		return $this;
	}

	public function statusSetModal() {
		$modal = new Modal('status-set-modal', [
			KlorchidStatusSetFormLayout::class,
		]);
		$modal->title(__('Are you sure to set a new Status ?'))
			->applyButton(__('Change'))
			->closeButton(__('Cancel'));

		return $modal;
	}

	public function statusSetButton() {

		return ModalToggle::make(__('Set Status'))
			->modal('status-set-modal')
			->parameters([
				'repository_action' => 'status_set',
				'run_validation' => true,
			])
		//->confirm(__("Are you sure? sdfsdfsdf sdufhsidgfs difgsid fsudgfsodfugsodhfgb sofqeojqprugrpt dlzkndlz jn lh ouhh "))
		//->canSee($this->userHasScreenActionPermission($this->getMode()))
			->method('runRepositoryAction')
		//->canSee($can_see)
		//->class($this->status ? 'btn btn-success' : 'btn btn-danger')
			->icon('check');
	}

}