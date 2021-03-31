<?php


namespace Kamansoft\Klorchid\Layouts\Contracts;


interface KlorchidMultimodeLayoutsInterface
{

    public function getRepositoryModeKeyName():string;
    public function getScreenMode():string;

}