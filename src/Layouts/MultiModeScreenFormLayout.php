<?php


namespace Kamansoft\Klorchid\Layouts;

use Kamansoft\Klorchid\Layouts\Contracts\MultiModeScreensLayoutInterface;
use Kamansoft\Klorchid\Layouts\Traits\MultiModeScreensLayoutTrait;


abstract class MultiModeScreenFormLayout extends KlorchidBasicFormLayout implements MultiModeScreensLayoutInterface
{

    use MultiModeScreensLayoutTrait;
}
