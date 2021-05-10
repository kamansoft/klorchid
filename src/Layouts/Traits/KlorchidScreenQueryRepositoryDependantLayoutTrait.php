<?php


namespace Kamansoft\Klorchid\Layouts\Traits;

use Kamansoft\Klorchid\Traits\KlorchidScreenQueryRepositoryDependentTrait;
use Orchid\Screen\Repository;
trait KlorchidScreenQueryRepositoryDependantLayoutTrait
{
    use KlorchidScreenQueryRepositoryDependentTrait;
    public function build(Repository $repository)
    {

        $this->initScreenQueryRequiredKeys()->screenQueryKeysCheck($repository);
        return parent::build($repository);
    }

}