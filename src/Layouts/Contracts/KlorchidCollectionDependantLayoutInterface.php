<?php


namespace Kamansoft\Klorchid\Layouts\Contracts;


use Kamansoft\Klorchid\Models\Contracts\KlorchidModelsInterface;

interface KlorchidCollectionDependantLayoutInterface
{

    public function getCollection();

    public static function getScreenQueryCollectionKeyname(): string;

    public function collectionDependantScreenQueryRequiredKeys(): array;

}