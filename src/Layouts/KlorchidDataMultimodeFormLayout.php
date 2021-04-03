<?php


namespace Kamansoft\Klorchid\Layouts;


use Kamansoft\Klorchid\Layouts\Contracts\KlorchidResourceDataLayoutInterface;
use Kamansoft\Klorchid\Layouts\Traits\KlorchidResourceDataLayoutTrait;

abstract class KlorchidDataMultimodeFormLayout extends KlorchidMultimodeLayout implements KlorchidResourceDataLayoutInterface
{

    use KlorchidResourceDataLayoutTrait;

    public function repositoryRequiredKeys(): array
    {
        return array_merge([
            $this->getRepositoryDataKeyName(),
        ], parent::repositoryRequiredKeys());
    }

    public function fields(): array
    {

    }

    abstract public function formFields(): array;
}