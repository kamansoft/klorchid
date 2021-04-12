<?php


namespace Kamansoft\Klorchid\Layouts\Contracts;


interface ScreenQueryDataBasedLayoutInterface
{
    public function dataAttribute(string $attributeName);

    public function getData();

    public function getScreenQueryDataKeyname();

    public function multiStatusScreenQueryRequiredKeys(): array;
}