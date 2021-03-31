<?php


namespace Kamansoft\Klorchid\Layouts\Contracts;


interface KlorchidDataBasedLayoutInterface
{
    public function getRepositoryDataKeyName():string;
    public function getScreenMode():string;
}