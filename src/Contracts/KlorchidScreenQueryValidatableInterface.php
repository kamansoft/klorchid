<?php


namespace Kamansoft\Klorchid\Contracts;

use Illuminate\Support\Collection;
use Orchid\Screen\Repository;

interface KlorchidScreenQueryValidatableInterface
{
    public function screenQueryRequiredKeys(): array;

    public function checkScreenQueryKeys(Repository $repository): self;

    public function getScreenQueryRequiredKeys(): Collection;

    public function setScreenQueryRequiredKeys(): self;
}