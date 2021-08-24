<?php


namespace Kamansoft\Klorchid\Layouts\Traits;

use Kamansoft\Klorchid\Traits\KlorchidScreenQueryRepositoryDependentTrait;
use Orchid\Screen\Repository;
trait KlorchidScreenQueryRepositoryDependantLayoutTrait
{
    use KlorchidScreenQueryRepositoryDependentTrait;

    /**
     * @param Repository $repository
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Throwable
     */
    public function build(Repository $repository)
    {
        $this->initScreenQueryRequiredKeys()->screenQueryKeysCheck($repository);
        return parent::build($repository);
    }

}