<?php


namespace Kamansoft\Klorchid\Layouts;


use Illuminate\Support\Collection;

use Kamansoft\Klorchid\Contracts\KlorchidScreenQueryValidatableInterface;
use Kamansoft\Klorchid\Layouts\Traits\ScreenQueryValidationForLayoutTrait;
use Orchid\Screen\Field;


abstract class KlorchidLayout extends \Orchid\Screen\Layouts\Rows implements KlorchidScreenQueryValidatableInterface
{

    use ScreenQueryValidationForLayoutTrait;
    public function screenQueryRequiredKeys(): array
    {
        return [];
    }



    public function __construct()
    {
        $this->setScreenQueryRequiredKeys();
    }


}