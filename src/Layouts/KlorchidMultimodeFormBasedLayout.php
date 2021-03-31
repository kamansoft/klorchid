<?php


namespace Kamansoft\Klorchid\Layouts;


use Kamansoft\Klorchid\Layouts\Contracts\KlorchidDataBasedLayoutInterface;
use Kamansoft\Klorchid\Layouts\Traits\KlorchidDataBasedLayoutTrait;

abstract class KlorchidMultimodeFormBasedLayout extends KlorchidMultimodeLayout implements KlorchidDataBasedLayoutInterface
{

    use KlorchidDataBasedLayoutTrait;

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