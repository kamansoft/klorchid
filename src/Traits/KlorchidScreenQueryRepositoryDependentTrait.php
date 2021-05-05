<?php


namespace Kamansoft\Klorchid\Traits;

use Exception;
use Illuminate\Support\Collection;
use Orchid\Screen\Repository;
use Kamansoft\Klorchid\Contracts\KlorchidScreenQueryRepositoryDependentInterface;

/**
 * @method KlorchidScreenQueryRepositoryDependentInterface screenQueryRequiredKeys()
 * screenQueryRequiredKeys()
 */
trait KlorchidScreenQueryRepositoryDependentTrait
{
    private Collection $required_keys;


    public function checkScreenQueryKeys(Repository $repository): self
    {

        $this->required_keys->map(function ($element_key) use ($repository) {
            if (is_null($repository->get($element_key))) {
                throw new Exception("Key name NOT FOUND ( \"$element_key\" ). A Klorchid Layout Instance needs the \"$element_key\" key with some value at the screen's query method returned array.", 1);
            }
        });
        return $this;
    }

    /**
     * Maps through class reflection object of this class using a needle (string for match) in search of methods
     * that would return extra screen required keys array, an them push it to the required keys collection
     * @param string $needle the name using to match all reflection class methods
     * @return $this
     * @throws \ReflectionException
     */
    public function pushRequiredKeysFromMethods(string $needle = "ScreenQueryRequiredKeys"):self{
        $methods = getObjectMethodsWith($this, $needle);
        $methods->map(function ($query_key_method) {
            collect($this->$query_key_method())->map(function ($query_key) {
                $this->getScreenQueryRequiredKeys()->push($query_key);
            });
        });
        return $this;
    }

    /**
     * @throws \ReflectionException
     */
    public function setScreenQueryRequiredKeys(): self
    {
        $this->required_keys = collect($this->screenQueryRequiredKeys());
        $this->pushRequiredKeysFromMethods();
        return $this;
    }

    public function getScreenQueryRequiredKeys(): Collection
    {
        return $this->required_keys;
    }


}
