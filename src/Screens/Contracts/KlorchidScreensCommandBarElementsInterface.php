<?php


namespace Kamansoft\Klorchid\Screens\Contracts;


use Illuminate\Support\Collection;

interface KlorchidScreensCommandBarElementsInterface
{

    public function initCommandBarElements(array $elements = null): self;

    public function setCommandBarElements(array $elements): self;

    public function getCommandBarElements(): Collection;

    public function commandBarElements(): array;

    public function commandBarCheck(): self;

}