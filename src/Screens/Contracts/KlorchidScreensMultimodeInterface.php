<?php


namespace Kamansoft\Klorchid\Screens\Contracts;

use Illuminate\Support\Collection;

interface KlorchidScreensMultimodeInterface
{


    /**
     * @return string
     */
    public function getMode(): string;

    /**
     * Only set a mode if it is available
     * @param string $mode
     * @return $this
     * @throws \Exception
     */
    public function setMode(string $mode): self;

    public function isValidMode($mode): bool;

    public function getModeMethod($mode): string;

    /**
     * Store the retun value of getModesByLayoutMethods to available_modes attribute
     *
     * @return $this
     * @throws \ReflectionException
     */
    public function setAvailableModes(Collection $modes): self;

    public function initAvailableModes(string $mode_methods_name_suffix): self;

    public function getAvailableModes(?string $mode_methods_name_suffix = null): Collection;

    /**
     * Maps thorough the reflectionClass object of an instance of this class,
     * get all the methods which name's ends with the value at $needle
     * and returns a collection with all of those methods
     * @param string $needle
     * @return Collection
     * @throws \ReflectionException
     */
    public function getModesByMethodsName(string $needle = 'Mode'): Collection;
}