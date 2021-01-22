<?php

namespace Kamansoft\Klorchid\Repository;
use Illuminate\Database\Eloquent\Model;

/**
 * Interface KlorchidRepositoryInterface
 * @package Kamansoft\Klorchid
 */
interface KlorchidRepositoryInterface
{



	//public function getConfirmationAttribute():string;
    public function getModel():Model;
    public function setModel(Model $model):self;




    


}
