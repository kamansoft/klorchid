<?php


namespace Kamansoft\Klorchid\Layouts\Traits;

use Kamansoft\Klorchid\Traits\KlorchidScreenQueryRepositoryDependentTrait;
use Orchid\Screen\Repository;
trait ScreenQueryValidationForLayoutsTrait
{
    use KlorchidScreenQueryRepositoryDependentTrait;
    public function build(Repository $repository)
    {
        $this->checkScreenQueryKeys($repository);
        return parent::build($repository);
    }

}