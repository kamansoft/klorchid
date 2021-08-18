<?php

namespace Kamansoft\Klorchid\Models\Traits;

use Kamansoft\Klorchid\Models\Presenters\BlamingPresenter;

trait BlamingPresentableTrait
{


    public function blamingPresenter(): BlamingPresenter
    {
        return new BlamingPresenter($this);
    }
}