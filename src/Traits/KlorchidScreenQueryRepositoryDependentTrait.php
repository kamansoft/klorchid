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


    public function screenQueryKeysCheck(Repository $repository): KlorchidScreenQueryRepositoryDependentInterface
    {

        $this->required_keys->map(function ($element_key) use ($repository) {
            if (is_null($repository->get($element_key))) {
                throw new Exception("Key name NOT FOUND ( \"$element_key\" ). ".static::class ." needs The \"$element_key\" key with some value on the query method returned array of any screen that uses it", 1);
            }
        });
        return $this;
    }


    public function getAllScreenQueryRequiredKeysFromMethods(string $needle = "ScreenQueryRequiredKeys"): Collection
    {
        $methods = getObjectMethodsThatEndsWith($this, $needle);


        $keys = collect([]);
        $methods->map(function ($query_key_method) use ($keys) {
            collect($this->$query_key_method())->map(function ($required_key) use ($keys) {
                $keys->add($required_key);
                return $required_key;
            });
        });
        return $keys;
    }

    /**
     * @throws \ReflectionException
     */
    public function setScreenQueryRequiredKeys(Collection $required_keys): KlorchidScreenQueryRepositoryDependentInterface
    {
        $this->required_keys = $required_keys;
        return $this;
    }

    public function initScreenQueryRequiredKeys(?array $required_keys = null): KlorchidScreenQueryRepositoryDependentInterface
    {
        $this->setScreenQueryRequiredKeys(empty($required_keys) ? $this->getAllScreenQueryRequiredKeysFromMethods() : collect($required_keys));
        return $this;
    }

    public function getScreenQueryRequiredKeys(): Collection
    {
        return $this->required_keys;
    }


}
