<?php


namespace Kamansoft\Klorchid\Models\Contracts;


interface BinaryStatusKlorchidModelsInterface
{
    static public function stringToStatus(string $status):bool;
    public function statusToggle(string $reason);

}