<?php


namespace Kamansoft\Klorchid\Traits;

use Illuminate\Support\Collection;
use Orchid\Screen\Repository;

trait KlorchidScreenQueryValidatable
{
    private Collection $required_keys;


    public function checkScreenQueryKeys(Repository $query): self
    {

        $this->required_keys->map(function ($element_key) use ($query) {
            if (is_null($query->get($element_key))) {
                throw new \Exception("Key name NOT FOUND ( \"$element_key\" ). A Klorchid Layout Instance needs the \"$element_key\" key with some value at the screen's query method returned array.", 1);
            }
        });
        return $this;
    }

    public function setScreenQueryRequiredKeys(): self
    {
        $this->required_keys = collect($this->screenQueryRequiredKeys());
        $methods = getObjectMethodsWith($this, 'ScreenQueryRequiredKeys');
        $methods->map(function ($query_keys_group, $key) {
            collect($this->$query_keys_group())->map(function ($query_key) {
                $this->getScreenQueryRequiredKeys()->push($query_key);
            });
        });
        return $this;
    }

    public function getScreenQueryRequiredKeys(): Collection
    {
        return $this->required_keys;
    }


}