<?php

namespace Kamansoft\Klorchid\Models\Traits;

use Kamansoft\Klorchid\Models\Presenters\PkPresenter;

trait PkPresentableTrait
{


    public function pkPresenter(): PkPresenter
    {
        return new PkPresenter($this);
    }



}