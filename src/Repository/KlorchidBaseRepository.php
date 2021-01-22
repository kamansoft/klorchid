<?php

namespace Kamansoft\Klorchid\Repository;

use Illuminate\Database\Eloquent\Model;
use Orchid\Screen\Layouts\Selection;

class KlorchidBaseRepository implements KlorchidRepositoryInterface {

	/**
	 * The main repository model object
	 * @var Model
	 */
	private $model;

	protected $filterSelection;

	public function __construct($model) {
		$this->model = $model;
	}

	public function getModel(): Model {
		return $this->model;
	}

	public function setModel(Model $model):self
    {
        $this->model= $model;
	    return $this;
    }

	public function setFilterSelection(Selection $selection): self{
		$this->filterSelection = $selection;
		return $this;
	}


}
