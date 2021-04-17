<?php


namespace Kamansoft\Klorchid\Layouts\Traits;

use Kamansoft\Klorchid\Traits\KlorchidScreenQueryValidatable;
use Orchid\Screen\Repository;
trait ScreenQueryValidationForLayoutTrait
{
    public function build(Repository $repository)
    {
        $this->checkScreenQueryKeys($repository);
        return parent::build($repository);
    }

}