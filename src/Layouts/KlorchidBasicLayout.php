<?php


namespace Kamansoft\Klorchid\Layouts;


use Illuminate\Support\Collection;

use Kamansoft\Klorchid\Contracts\KlorchidScreenQueryRepositoryDependentInterface;
use Kamansoft\Klorchid\Layouts\Traits\ScreenQueryValidationForLayoutsTrait;
use Kamansoft\Klorchid\Traits\KlorchidScreenQueryRepositoryDependentTrait;
use Orchid\Screen\Field;
use Orchid\Screen\Layouts\Rows;


abstract class KlorchidBasicLayout extends Rows implements KlorchidScreenQueryRepositoryDependentInterface
{
    use KlorchidScreenQueryRepositoryDependentTrait;
    use ScreenQueryValidationForLayoutsTrait;

    public function screenQueryRequiredKeys(): array
    {
        return [];
    }

    /**
     * @throws \ReflectionException
     */
    public function __construct()
    {
        $this->setScreenQueryRequiredKeys();
    }


}
