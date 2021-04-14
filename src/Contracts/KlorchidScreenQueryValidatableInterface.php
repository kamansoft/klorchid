<?php


namespace Kamansoft\Klorchid\Contracts;

use Illuminate\Support\Collection;
use Orchid\Screen\Repository;

interface KlorchidScreenQueryValidatableInterface
{

    /**
     * method that returns an array with all the needed keys from Screen
     * @return array
     */
    public function screenQueryRequiredKeys(): array;

    /**
     * Maps through class reflection object of this class using a needle (string for match) in search of methods
     * that would return extra screen required keys array, an them push it to the required keys collection
     * @param string $needle the name using to match all reflection class methods
     * @return $this
     * @throws \ReflectionException
     */
    public function pushRequiredKeysFromMethods(string $needle = "ScreenQueryRequiredKeys"):self;


    public function setScreenQueryRequiredKeys(): self;

    /**
     * @param \Orchid\Screen\Repository $repository
     * @return $this
     */
    public function checkScreenQueryKeys(Repository $repository): self;

    public function getScreenQueryRequiredKeys(): Collection;


}