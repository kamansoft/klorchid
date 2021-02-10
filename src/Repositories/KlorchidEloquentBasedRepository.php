<?php

namespace Kamansoft\Klorchid\Repositories;

use Illuminate\Database\Eloquent\Model;
//use Orchid\Platform\Dashboard;
use Orchid\Screen\Layouts\Selection;
use Illuminate\Contracts\Routing\UrlRoutable;
use Illuminate\Http\Request;
use Kamansoft\Klorchid\Notificator\NotificaterInterface;
use Kamansoft\Klorchid\Repositories\KlorchiPermissedActionRepositoryInterface;


use Kamansoft\Klorchid\GraphicUserInterfaceInterface;

abstract class KlorchidEloquentBasedRepository implements KlorchidRepositoryInterface, UrlRoutable
{

    /**
     * The main repository model object
     * @var Model
     */
    private Model $model;
    private Request $request;
    private NotificaterInterface $notificator;


    /**
     * @var Dashboard Current instance of the grafic user insteface object
     */
    private Dashboard $GUI;


    /**
     * @return Request
     */
    public function getRequest(): Request
    {
        return $this->request;
    }

    /**
     * @param Request $request
     * @return KlorchidEloquentBasedRepository
     */
    public function setRequest(Request $request): KlorchidEloquentBasedRepository
    {
        $this->request = $request;
        return $this;
    }

    protected $filterSelection;

    public function __construct(Model $model, Request $request, NotificaterInterface $notificator)//, Dashboard $gui)
    {
        $this->model = $model;
        $this->request = $request;
        $this->notificator = $notificator;
        //config('klorchid.repository_pk_name');
        
        $model_pk_value = $this->getFirstRequestRouteParam();
        if ($model_pk_value){
            $this->resolveRouteBinding($model_pk_value);    
        }
         
        //dd($this->getFirstRequestRouteParam());
        //$this->GUI = $gui;


    }

    public function getFirstRequestRouteParam(){
        return reset(request()->route()->parameters);
    }

    public function getModel(): Model
    {
        return $this->model;
    }

    public function setModel(?Model $model = null): self
    {
        if (!is_null($model)) {
            $this->model = $model;
        }
        return $this;
    }

    public function setFilterSelection(Selection $selection): self
    {
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

    public function resolveRouteBindingKernel($value, $field = null)
    {

        $model = $this->model->resolveRouteBinding($value, $field);
        if (is_null($model)) {
            return false;
        } else {
            $this->setModel($model);
            return true;
        }
    }

    public function resolveRouteBinding($value, $field = null)
    {

        if (!$this->resolveRouteBindingKernel($value, $field)) {

            $this->notificator->setMode('alert')->error(__('Record Not Found'));
            back();

        }

        return $this;

    }

    public function resolveChildRouteBinding($childType, $value, $field)
    {
        return $this->setModel($this->model->resolveChildRouteBinding($childType, $value, $field));
        //return $this;
    }


    




}
