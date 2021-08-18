<?php

namespace Kamansoft\Klorchid\Models\Contracts;

use Kamansoft\Klorchid\Models\Presenters\BlamingPresenter;

interface BlamingPrensentableInterface
{
    public function blamingPresenter(): BlamingPresenter;

}