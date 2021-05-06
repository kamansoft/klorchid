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


    public function screenQueryKeysCheck(Repository $repository): self
    {

        $this->required_keys->map(function ($element_key) use ($repository) {
            if (is_null($repository->get($element_key))) {
                throw new Exception("Key name NOT FOUND ( \"$element_key\" ). A Klorchid Layout Instance needs the \"$element_key\" key with some value at the screen's query method returned array.", 1);
            }
        });
        return $this;
    }

    /**
     * Maps through class reflection object of this class using a needle (string used as sufix for name match) in search
     * of the methods that would return extra screen query required keys as an array, them push it to the required keys collection
     * @param string $needle the name using to match all reflection class methods
     * @return $this
     * @throws \ReflectionException
     */
    public function pushRequiredKeysFromMethods(string $needle = "ScreenQueryRequiredKeys"): self
    {
        $methods = getObjectMethodsWith($this, $needle);
        $methods->map(function ($query_key_method) {
            collect($this->$query_key_method())->map(function ($query_key) {
                $this->getScreenQueryRequiredKeys()->push($query_key);
            });
        });
        return $this;
    }

    public function getAllScreenQueryRequiredKeysFromMethods(string $needle = "ScreenQueryRequiredKeys"): Collection
    {
        $methods = getObjectMethodsWith($this, $needle);

        return $methods->map(function ($query_key_method) {
            collect($this->$query_key_method())->map(function ($query_required_key) {
                return $query_required_key;
            });
        });
    }

    /**
     * @throws \ReflectionException
     */
    public function setScreenQueryRequiredKeys(Collection $required_keys): self
    {
        $this->required_keys = $required_keys;
        return $this;
    }

    public function initScreenQueryRequiredKeys(?array $required_keys = null): self
    {
        $this->setScreenQueryRequiredKeys(empty($required_keys)?$this->getAllScreenQueryRequiredKeysFromMethods():collect($required_keys));
        return $this;
    }

    public
    function getScreenQueryRequiredKeys(): Collection
    {
        return $this->required_keys;
    }


}
