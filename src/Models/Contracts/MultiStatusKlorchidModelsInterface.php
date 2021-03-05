<?php


namespace Kamansoft\Klorchid\Models\Contracts;


interface MultiStatusKlorchidModelsInterface
{
    static public function stringToStatus(string $status):string;
    public function statusToggle(string $reason);

}