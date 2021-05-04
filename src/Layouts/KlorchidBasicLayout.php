<?php


namespace Kamansoft\Klorchid\Layouts;


use Illuminate\Support\Collection;

use Kamansoft\Klorchid\Contracts\KlorchidScreenQueryValidatableInterface;
use Kamansoft\Klorchid\Layouts\Traits\ScreenQueryValidationForLayoutsTrait;
use Kamansoft\Klorchid\Traits\KlorchidScreenQueryValidatable;
use Orchid\Screen\Field;
use Orchid\Screen\Layouts\Rows;


abstract class KlorchidBasicLayout extends Rows implements KlorchidScreenQueryValidatableInterface
{
    use KlorchidScreenQueryValidatable;
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
