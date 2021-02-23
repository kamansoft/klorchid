<?php


trait KlorchidMultimodeScreenLayoutsTrait
{
public function getScreenMode() {

		$query_key_name = config('klorchid.screen_query_required_elements.screen_mode_layout');

		return $query_key_name ? $this->query->get($query_key_name) : null;

	}

	public function getScreenActionPerm(string $mode) {

		$query_key_name = config('klorchid.screen_query_required_elements.screen_action_perms');

		return $query_key_name ? $this->query->get($query_key_name)->get($mode) : null;

	}


	public function fieldIsEditable( ? object $element = null) {
		$to_return = false;
		$element = $element ?? $this->getModel();

		if ($this->fieldIsDissabled($element) === false) {

			$to_return = true;
			if (
				$this->getScreenMode() === 'create' and
				!is_null($this->getScreenActionPerm('create')) and
				$this->userHasPermission($this->getScreenActionPerm('create')) === false
			) {
				$to_return = false;
			} elseif (
				$this->getScreenMode() === 'edit' and
				!is_null($this->getScreenActionPerm('edit')) and
				$this->userHasPermission($this->getScreenActionPerm('edit')) === false
			) {
				$to_return = false;
			}
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

}