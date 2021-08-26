<?php


namespace Kamansoft\Klorchid\Layouts\Contracts;


interface MultiModeScreensLayoutInterface
{

    public function multiModeScreenQueryRequiredKeys(): array;

    public function getScreenQueryModeKeyname(): string;

    public function getScreenMode(): string;


}