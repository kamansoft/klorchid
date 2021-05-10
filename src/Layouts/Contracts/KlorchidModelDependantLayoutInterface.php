<?php


namespace Kamansoft\Klorchid\Layouts\Contracts;


use Kamansoft\Klorchid\Models\Contracts\KlorchidModelsInterface;

interface KlorchidModelDependantLayoutInterface
{

    public function getModel();

    public function getScreenQueryModelKeyname(): string;

    public function modelDependantScreenQueryRequiredKeys(): array;

}