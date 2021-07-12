<?php


namespace Kamansoft\Klorchid\Layouts;


use Kamansoft\Klorchid\Layouts\Contracts\KlorchidFormsLayoutInterface;
use Kamansoft\Klorchid\Layouts\Contracts\KlorchidRouteNamesDependantLayoutInterface;
use Kamansoft\Klorchid\Layouts\Contracts\MultiModeScreensLayoutInterface;
use Kamansoft\Klorchid\Layouts\Contracts\MultiStatusModelLayoutInterface;
use Kamansoft\Klorchid\Layouts\Contracts\KlorchidModelDependantLayoutInterface;
use Kamansoft\Klorchid\Layouts\KlorchidBasicFormLayout;
use Kamansoft\Klorchid\Layouts\Traits\KlorchidFormLayoutTrait;
use Kamansoft\Klorchid\Layouts\Traits\KlorchidRouteNamesDependantLayoutTrait;
use Kamansoft\Klorchid\Layouts\Traits\KlorchidScreenQueryRepositoryDependantLayoutTrait;
use Kamansoft\Klorchid\Layouts\Traits\MultiModeScreensLayoutTrait;
use Kamansoft\Klorchid\Layouts\Traits\MultiStatusModelLayoutTrait;
use Kamansoft\Klorchid\Layouts\Traits\KlorchidModelDependantLayoutTrait;
use Kamansoft\Klorchid\Screens\KlorchidCrudScreen;
use Kamansoft\Klorchid\Traits\KlorchidScreenQueryRepositoryDependentTrait;
use Orchid\Screen\Field;
use Orchid\Screen\Fields\Input;

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


    static public  array $displayable_modes = [
        KlorchidCrudScreen::EDIT_MODE,
        KlorchidCrudScreen::CREATE_MODE,
        KlorchidCrudScreen::VIEW_MODE
    ];

    public function isEditable()
    {
        return $this->getScreenMode() === KlorchidCrudScreen::EDIT_MODE or
            $this->getScreenMode() === KlorchidCrudScreen::CREATE_MODE;
    }

    public function crudClass()
    {

        return 'form-control ' . ($this->isEditable() ?: 'text-dark');
    }

    public function isDisplayable()
    {
        $mode = $this->getScreenMode();
        return in_array($this->getScreenMode(), self::$displayable_modes, true);
    }
}