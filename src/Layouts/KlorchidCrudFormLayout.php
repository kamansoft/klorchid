<?php


namespace Kamansoft\Klorchid\Layouts;


use Kamansoft\Klorchid\Layouts\Contracts\KlorchidFormsLayoutInterface;
use Kamansoft\Klorchid\Layouts\Contracts\KlorchidModelDependantLayoutInterface;
use Kamansoft\Klorchid\Layouts\Contracts\KlorchidRouteNamesDependantLayoutInterface;
use Kamansoft\Klorchid\Layouts\Contracts\MultiModeScreensLayoutInterface;
use Kamansoft\Klorchid\Layouts\Traits\KlorchidFormLayoutTrait;
use Kamansoft\Klorchid\Layouts\Traits\KlorchidModelDependantLayoutTrait;
use Kamansoft\Klorchid\Layouts\Traits\KlorchidRouteNamesDependantLayoutTrait;
use Kamansoft\Klorchid\Layouts\Traits\MultiModeScreensLayoutTrait;
use Kamansoft\Klorchid\Layouts\Traits\MultiStatusModelLayoutTrait;
use Kamansoft\Klorchid\Screens\KlorchidCrudScreen;

abstract class KlorchidCrudFormLayout extends KlorchidBasicFormLayout
    implements KlorchidModelDependantLayoutInterface, MultiModeScreensLayoutInterface,
    KlorchidRouteNamesDependantLayoutInterface,
    KlorchidFormsLayoutInterface//, MultiStatusModelLayoutInterface

{
    use KlorchidModelDependantLayoutTrait;
    use KlorchidRouteNamesDependantLayoutTrait;
    use MultiModeScreensLayoutTrait;
    use MultiStatusModelLayoutTrait;
    use KlorchidFormLayoutTrait;


    static public array $displayable_modes = [
        KlorchidCrudScreen::EDIT_MODE,
        KlorchidCrudScreen::CREATE_MODE,
        KlorchidCrudScreen::VIEW_MODE
    ];



    public function __construct()
    {
        if (empty($this->target)) {
            $this->target = self::getScreenQueryModelKeyname();
        } else {
            Log::info(static::class . " Common orchid \"target\" will be used with the value: " . $this->target . " instead of klorchid common value for form layout: " . self::getScreenQueryModelKeyname()." at screen: ".get_class(Dashboard::getCurrentScreen()));
            self::setScreenQueryModelKeyname($this->target);
        }

    }

    public function crudClass()
    {

        return 'form-control ' . ($this->isEditable() ?: 'text-dark');
    }

    public function isEditable()
    {
        return $this->getScreenMode() === KlorchidCrudScreen::EDIT_MODE or
            $this->getScreenMode() === KlorchidCrudScreen::CREATE_MODE;
    }

    public function isDisplayableOnCurrentMode() : bool
    {

        return in_array($this->getScreenMode(), static::$displayable_modes, true);
    }


}