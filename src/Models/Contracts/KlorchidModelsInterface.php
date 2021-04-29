<?php


namespace Kamansoft\Klorchid\Models\Contracts;

use Kamansoft\Klorchid\Models\Presenters\PkPresenter;
interface KlorchidModelsInterface
{


    static public function userModelClass(): string;

    public function pkPresenter(): PkPresenter;

    public function setCasts(): self;


}