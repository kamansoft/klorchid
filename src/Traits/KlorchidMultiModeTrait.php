<?php


namespace Kamansoft\Klorchid\Traits;

use Illuminate\Support\Collection;
use Illuminate\Support\Str;

trait KlorchidMultiModeTrait
{

    protected Collection $available_modes;
    protected string $mode;

    /**
     * @return string
     */
    public function getMode(): string
    {
        return $this->mode;
    }

    /**
     * Only set a mode if it is available
     * @param string $mode
     * @return $this
     * @throws \Exception
     */
    public function setMode(string $mode): self
    {
        if ($this->isValidMode($mode)) {
            $this->mode = $mode;
        } else {
            throw new \Exception('Can\'t set "' . $mode . '" as current  mode, due to "' . $mode . '" is not a ' . self::class . ' valid mode. ');
        }
        return $this;
    }

    public function isValidMode($mode): bool
    {
        return (bool)$this->getModeMethod($mode);
    }

    public function getModeMethod($mode):string
    {
        return $this->available_modes->get($mode);
    }

    /**
     * Store the retun value of getModesByLayoutMethods to available_modes attribute
     *
     * @return $this
     * @throws \ReflectionException
     */
    public function setAvailableModes(Collection $modes): self
    {
        $this->available_modes = $modes;
        return $this;
    }

    /**
     * @param string $mode_methods_name_suffix
     * @return $this
     * @throws \ReflectionException
     */
    public function initAvailableModes(string $mode_methods_name_suffix): self
    {
        if (!isset($this->available_modes)) {
            $this->setAvailableModes($this->getModesByMethodsName($mode_methods_name_suffix));
        }
        return $this;
    }

    public function getAvailableModes(?string $mode_methods_name_suffix = null): Collection
    {
        if (!is_null($mode_methods_name_suffix)) {
            $this->initAvailableModes($mode_methods_name_suffix);
        }
        return $this->available_modes;
    }


    /**
     * Maps thorough the reflectionClass object of an instance of this class,
     * get all the methods which name's ends with the value at $needle
     * and returns a collection with all of those methods
     * @param string $needle
     * @return Collection
     * @throws \ReflectionException
     */
    public function getModesByMethodsName(string $needle = 'Mode'): Collection
    {
        return getObjectMethodsWith($this, $needle);
    }


}