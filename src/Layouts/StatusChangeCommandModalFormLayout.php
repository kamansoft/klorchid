<?php


namespace Kamansoft\Klorchid\Layouts;


use Kamansoft\Klorchid\Layouts\Traits\StatusFieldsTrait;
use Orchid\Screen\Field;

class StatusChangeCommandModalFormLayout extends MultiStatusModelFormLayout
{
    use StatusFieldsTrait;

    /**
     * @inheritDoc
     */
    public function fields(): array
    {
        return array_merge(
            $this->statusFields(
                self::getScreenQueryModelKeyname(),
            ),
            $this->newStatusFields(
                self::getScreenQueryModelKeyname(),
                $this->getModel()->statusPresenter()->getOptions()
            )
        );
    }
}