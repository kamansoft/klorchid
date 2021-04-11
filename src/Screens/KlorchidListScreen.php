<?php


namespace Kamansoft\Klorchid\Screens;


use Kamansoft\Klorchid\Repositories\Contracts\KlorchidRepositoryInterface;
use Orchid\Screen\Layout;

abstract class KlorchidListScreen extends \Orchid\Screen\Screen
{

    private $repository  = null;
    public function setRepository($repository): self
    {
        $this->repository = $repository;
        return $this;
    }
    public function getRepository(){
       return  $this->repository;
    }

    public function __construct(?KlorchidRepositoryInterface $repository)
    {
        if (!is_null($repository)) {
            $this->setRepository($repository);
        }

    }

    abstract public function listLayout():array;


    /**
     * @inheritDoc
     */
    public function layout(): array
    {

       $layout=[];


        return $this->listLayout();



    }



}