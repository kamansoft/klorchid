<?php


namespace Kamansoft\Klorchid\Layouts\Contracts;


use Orchid\Screen\Repository;

interface KlorchidLayoutsInterface
{
    public function repositoryRequiredKeys():array;
    public function checkRequiredRepositoryAttributes(Repository $repository);


}