<?php

namespace Kamansoft\Klorchid\Repository;

use Illuminate\Database\Eloquent\Model;
use Orchid\Screen\Layouts\Selection;
use Illuminate\Contracts\Routing\UrlRoutable;

class KlorchidEloquentBasedRepository implements KlorchidRepositoryInterface, UrlRoutable {

	/**
	 * The main repository model object
	 * @var Model
	 */
	private $model;

	protected $filterSelection;

	public function __construct(Model $model) {
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


    public function getRouteKey()
    {
        return $this->model->getRouteKey();
    }

    public function getRouteKeyName()
    {

        return $this->model->getRouteKeyName();
    }

    public function resolveRouteBinding($value, $field = null)
    {

        $this->setModel($this->model->resolveRouteBinding($value,$field))  ;
        return $this;
    }

    public function resolveChildRouteBinding($childType, $value, $field)
    {
        $this->setModel($this->model->resolveChildRouteBinding($childType, $value, $field));
        return $this;
    }
}
