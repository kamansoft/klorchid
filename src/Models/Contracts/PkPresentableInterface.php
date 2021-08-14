<?php
namespace Kamansoft\Klorchid\Models\Contracts;
use Kamansoft\Klorchid\Models\Presenters\PkPresenter;

interface PkPresentableInterface
{
    public function pkPresenter(): PkPresenter;

}