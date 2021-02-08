<?php

namespace Kamansoft\Klorchid\Layouts;

trait KlorchidLayoutFieldsTrait {
	public function getModel() {
		$query_key_name = config('klorchid.screen_query_required_elements.element_to_display');

		return $query_key_name ? $this->query->get($query_key_name) : null;
	}
	public function getScreenMode() {

		$query_key_name = config('klorchid.screen_query_required_elements.screen_mode_layout');

		return $query_key_name ? $this->query->get($query_key_name) : null;

	}

	public function getScreenModePerm(string $mode) {

		$query_key_name = config('klorchid.screen_query_required_elements.screen_mode_perms');

		return $query_key_name ? $this->query->get($query_key_name)->get($mode) : null;

	}

	//perhabs this can go in a trait to make it  usable in other layout class
	public function fieldIsEditable( ? object $element = null) {
		$to_return = false;
		$element = $element ?? $this->getModel();

		if ($this->fieldIsDissabled($element) === false) {

			$to_return = true;
			if (
				$this->getScreenMode() === 'create' and
				!is_null($this->getScreenModePerm('create')) and
				$this->userHasPermission($this->getScreenModePerm('create')) === false
			) {
				$to_return = false;
			} elseif (
				$this->getScreenMode() === 'edit' and
				!is_null($this->getScreenModePerm('edit')) and
				$this->userHasPermission($this->getScreenModePerm('edit')) === false
			) {
				$to_return = false;
			}
		}

		return $to_return;
	}

	public function fieldIsDissabled( ? object $element = null) : bool{
		$element = $element ?? $this->getModel();
		$to_return = false;
		if (property_exists($element, 'status')) {
			$to_return = !boolval($element->status);
		}
		return $to_return;
	}

	public function klorchidFieldClass(string $extra = 'form-control ',  ? object $element = null) {
		$element = $element ?? $this->getModel();

		$to_return = 'text-dark';

		$action = $this->getScreenMode();
		if ($action == 'default') {
			$to_return = 'text-muted';
		};
		if ($this->fieldIsDissabled($element)) {
			$to_return = 'text-danger';
		}

		$to_return = $to_return . ' ' . $extra;

		return $to_return;

	}

	public function klorchidFieldStatusClass(string $extra = 'form-control ',  ? object $element = null) {
		$element = $element ?? $this->getModel();
		if ($this->fieldIsDissabled($element)) {
			$to_return = 'text-danger';
		}else{
			$to_return = 'text-success';
		}
		$to_return = $to_return . ' ' . $extra;

		return $to_return;
	}
}
