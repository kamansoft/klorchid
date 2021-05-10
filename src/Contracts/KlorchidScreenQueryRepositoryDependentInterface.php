<?php


namespace Kamansoft\Klorchid\Contracts;

use Illuminate\Support\Collection;
use Orchid\Screen\Repository;

interface KlorchidScreenQueryRepositoryDependentInterface
{
    public function screenQueryKeysCheck(Repository $repository): self;


    public function getAllScreenQueryRequiredKeysFromMethods(string $needle = "ScreenQueryRequiredKeys"): Collection;

    /**
     * @throws \ReflectionException
     */
    public function setScreenQueryRequiredKeys(Collection $required_keys): self;

    public function initScreenQueryRequiredKeys(?array $required_keys = null): self;

    public function getScreenQueryRequiredKeys(): Collection;


}