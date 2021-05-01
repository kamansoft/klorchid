<?php


namespace Kamansoft\Klorchid\Screens\Contracts;


interface KlorchidScreensCommandBarInterface
{
    public function commandBarElements(): array;

    public function commandBarCheck(): self;
}