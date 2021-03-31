<?php


namespace Kamansoft\Klorchid\Layouts;


use Kamansoft\Klorchid\Layouts\Contracts\KlorchidLayoutsInterface;
use Kamansoft\Klorchid\Layouts\Traits\KlorchidLayoutsTrait;
use Orchid\Screen\Field;
use Orchid\Screen\Repository;

abstract class KlorchidLayout extends \Orchid\Screen\Layouts\Rows implements KlorchidLayoutsInterface
{
    use KlorchidLayoutsTrait;

    public function repositoryRequiredKeys():array{
        return [];
    }
    public function build(Repository $repository)
    {
        $this->checkRequiredRepositoryAttributes($repository);
        return parent::build($repository);
    }


}