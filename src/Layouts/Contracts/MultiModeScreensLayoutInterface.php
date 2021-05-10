<?php


namespace Kamansoft\Klorchid\Layouts\Contracts;


use Kamansoft\Klorchid\Contracts\KlorchidScreenQueryRepositoryDependentInterface;

interface MultiModeScreensLayoutInterface
{

    public function multiModeScreenQueryRequiredKeys(): array;

    public function getScreenQueryModeKeyname(): string;

    public function getScreenMode(): string;
}