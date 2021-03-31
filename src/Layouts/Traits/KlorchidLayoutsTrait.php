<?php

namespace Kamansoft\Klorchid\Layouts\Traits;

use Orchid\Screen\Repository;

trait KlorchidLayoutsTrait
{

    public function checkRequiredRepositoryAttributes(Repository $repository){

        collect($this->repositoryRequiredKeys())->map(function ($element_key) use ($repository) {
            if (is_null($repository->get($element_key))) {
                throw new \Exception("Key name NOT FOUND ( \"$element_key\" ). A Klorchid Layout Instance needs the \"$element_key\" key with some value at the screen's query method returned array.", 1);
            }
        });
        return $this;
    }



}