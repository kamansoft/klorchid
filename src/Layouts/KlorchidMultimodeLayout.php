<?php


namespace Kamansoft\Klorchid\Layouts;


use Kamansoft\Klorchid\Layouts\Contracts\KlorchidMultimodeLayoutsInterface;
use Kamansoft\Klorchid\Layouts\Traits\KlorchidMultimodeLayoutsTrait;
use Orchid\Screen\Field;

abstract class KlorchidMultimodeLayout extends KlorchidLayout implements KlorchidMultimodeLayoutsInterface
{
    use KlorchidMultimodeLayoutsTrait;

    public function repositoryRequiredKeys():array{
        return array_merge([
            $this->getRepositoryModeKeyName()
        ],parent::repositoryRequiredKeys());
    }


}