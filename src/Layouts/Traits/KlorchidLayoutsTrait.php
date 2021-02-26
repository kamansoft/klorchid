<?php

namespace Kamansoft\Klorchid\Layouts\Traits;

trait KlorchidLayoutsTrait
{

    public function checkScreenQueryAttributes(){

        collect(config('klorchid.screen_query_required_elements'))->map(function ($element_key) {
            if (is_null($this->query->get($element_key))) {
                throw new \Exception("\"$element_key\" key was not found. '" . self::class . "' instances needs the \"$element_key\" key at the screen query returned array", 1);
            }
        });
        return $this;
    }



}