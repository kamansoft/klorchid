<?php


namespace Kamansoft\Klorchid\Layouts\Traits;


trait KlorchidDataBasedLayoutTrait
{

    public $repository_data_keyname = 'data';

    public function getData():string{
        return $this->query->get($this->getRepositoryDataKeyName());
    }

    public function getRepositoryDataKeyName():string{
        return $this->repository_data_keyname;
    }

}