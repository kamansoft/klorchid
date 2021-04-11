<?php


namespace Kamansoft\Klorchid\Traits;

use Illuminate\Support\Collection;
use Illuminate\Support\Str;

trait KlorchidMultiModeTrait
{

    protected Collection $available_modes;
    protected string $mode  ;

    /**
     * @return string
     */
    public function getMode(): string
    {
        return $this->mode;
    }

    /**
     * @param string $mode
     * @return KlorchidMultiModeTrait
     */
    public function setMode(?string $mode = null)
    {
        if (is_null($mode)) {
            Log::warning(self::class . ' avoiding the attempt to set null as mode ');
            return $this;
        }
        if ($this->isValidMode($mode)) {
            $this->mode = $mode;
        } else {
            throw new \Exception('Can\'t set "' . $mode . '" as current  mode, due to "' . $mode . '" is not a '.self::class.' valid mode. ');
        }
        return $this;

    }

    public function isValidMode($mode)
    {
        return $this->getModeMethod($mode) ? true : false;
    }

    public function getModeMethod($mode)
    {
        return $this->available_modes->get($mode);
    }

    /**
     * Store the retun value of getModesByLayoutMethods to available_modes attribute
     *
     * @return $this
     * @throws \ReflectionException
     */
    public function setAvailableModes(?Collection $modes)
    {
        $this->available_modes = $modes ?? $this->getModesByMethodsName();
        return $this;
    }

    public function getAvailableModes(){
        $this->available_modes;
    }


    /**
     * Maps thorug the reflectionClass object of an instance of this class, and returns all the methods
     * which name's ends with the value at $needle .
     * and returns a collection with all of those methods
     * @param string $needle
     * @return Collection
     * @throws \ReflectionException
     */
    public function getModesByMethodsName(string $needle = 'Mode'): Collection
    {
        return getObjectMethodsWith($this,$needle);
    }



}