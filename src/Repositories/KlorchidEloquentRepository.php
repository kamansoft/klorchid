<?php

namespace Kamansoft\Klorchid\Repositories;

use Illuminate\Contracts\Routing\UrlRoutable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Kamansoft\Klorchid\Notificator\NotificaterInterface;
use Kamansoft\Klorchid\Repositories\Contracts\KlorchidRepositoryInterface;


//use Orchid\Platform\Dashboard;


abstract class KlorchidEloquentRepository implements KlorchidRepositoryInterface, UrlRoutable
{

    //use KlorchidCrudRepositoryTrait;


    protected $filterSelection;
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

    public function __construct(Model &$model, Request &$request, NotificaterInterface $notificator)//, Dashboard $gui)
    {
        $this->model = $model;
        $this->request = $request;
        $this->notificator = $notificator;
        //config('klorchid.repository_pk_name');


        if ($this->isPkInRequest()) {
            $this->resolveRouteBinding($this->getRequestPkValue());

        }

        //dd($this->getRequestPkValue());
        //$this->GUI = $gui;


    }


    public function isPkInRequest(): bool
    {
        return array_key_exists(config('klorchid.repository_pk_name'), $this->getRequest()->route()->parameters);
    }

    public function getRequestPkValue()
    {


        return array_key_exists(
            config('klorchid.repository_pk_name'),
            $this->getRequest()->route()->parameters)
            ? $this->getRequest()->route()->parameters[config('klorchid.repository_pk_name')] :
            null;
    }

    public function resolveRouteBinding($value, $field = null)
    {


        if (!$this->resolveRouteBindingKernel($value, $field)) {
            if ($this->request->wantsJson()) {
                //abort(404);
            } else {
                abort(404);

            }
        }


        return $this;

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

    public function exists(): bool
    {
        return $this->getModel()->exists;
    }


    public function getRouteKey()
    {
        return $this->model->getRouteKey();
    }

    public function getRouteKeyName()
    {

        return $this->model->getRouteKeyName();
    }

    public function resolveChildRouteBinding($childType, $value, $field)
    {
        return $this->setModel($this->getModel()->resolveChildRouteBinding($childType, $value, $field));
        //return $this;
    }


    public function validate(array $data_to_validate, array $rules = [])
    {

        return $this->request->validate($rules);

    }


    public function save(array $data):bool
    {
        try {
            $save_executed = $this->getModel()->fill($data)->save();
            //$save_executed = false;
            if ($save_executed) {
                $pk_name = $this->getModel()->getKeyName();
                Log::alert(self::class . " repository model added a row at " . $this->getModel()->getTable() . ' table with '.$pk_name.'='.$this->getModel()->$pk_name);
            }
            return $save_executed;
        }catch (\Illuminate\Database\QueryException $queryException){
            Log::error("Save repository SQL query error on model save".' '.$queryException->getMessage());
            //throw new \Exception("Save repository querry error on model save".' '.$queryException->getMessage());
            return false;
        }


    }


}
