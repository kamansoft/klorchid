<?php


namespace Kamansoft\Klorchid\Models\Contracts;


interface KlorchidEloquentModelInterface
{
    public function creator();

    public function updater();

    public function getCreatorNameAttribute();

    public function getUpdaterNameAttribute();


}