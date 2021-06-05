<?php

namespace Kamansoft\Klorchid\Screens;


use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;

use Kamansoft\Klorchid\Layouts\KlorchidCrudFormLayout;
use Kamansoft\Klorchid\Layouts\KlorchidListLayout;
use Kamansoft\Klorchid\Models\KlorchidEloquentModel;
use Kamansoft\Klorchid\Notificator\Notificator;
use Kamansoft\Klorchid\Screens\Contracts\KlorchidScreensPermissionsInterface;
use Kamansoft\Klorchid\Screens\Contracts\SaveCommandInterface;
use Kamansoft\Klorchid\Screens\Contracts\KlorchidScreensCommandBarElementsInterface;
use Kamansoft\Klorchid\Screens\Contracts\StatusChangeCommandInterface;
use Kamansoft\Klorchid\Screens\KlorchidCrudScreenBK;
use Kamansoft\Klorchid\Screens\KlorchidMultiModeScreen;

use Kamansoft\Klorchid\Screens\Traits\KlorchidCrudScreensCommandBarElementsTrait;
use Kamansoft\Klorchid\Screens\Traits\KlorchidScreensPermissionsTrait;

use Kamansoft\Klorchid\Screens\Traits\SaveCommandTrait;
use Kamansoft\Klorchid\Screens\Traits\StatusChangeCommandTrait;
use Kamansoft\Klorchid\Traits\KlorchidMultiModeTrait;
use Kamansoft\Klorchid\Traits\KlorchidPermissionsTrait;
use Orchid\Screen\Action;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Dashboard;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Fields\Input;
use Orchid\Support\Facades\Alert;
use Orchid\Support\Facades\Layout;
use Illuminate\Database\Eloquent\Builder;

//class KlorchidTestScreen extends KlorchidMultiModeScreen
abstract class KlorchidCrudScreen extends KlorchidMultiModeScreen
    implements KlorchidScreensPermissionsInterface, SaveCommandInterface,
    StatusChangeCommandInterface, KlorchidScreensCommandBarElementsInterface
{


    use KlorchidScreensPermissionsTrait;
    use StatusChangeCommandTrait;
    use SaveCommandTrait;
    use KlorchidCrudScreensCommandBarElementsTrait;


    const COLLECTION_MODE = 'list';
    const CREATE_MODE = 'create';
    const EDIT_MODE = 'edit';
    const VIEW_MODE = 'view';
    const DELETE_ACTION = 'delete';
    const STATUS_CHANGE_ACTION = 'status_change';

    //abstract public function permissionsGroupName(): string;

    abstract public function collectionQuery();

    /*
        public function actionPermissionsMap(): array
        {
            return [
                self::COLLECTION_MODE => implodeWithDot('platform', $this->permissionsGroupName(), self::COLLECTION_MODE),
                self::EDIT_MODE => implodeWithDot('platform', $this->permissionsGroupName(), self::EDIT_MODE),
                self::CREATE_MODE => implodeWithDot('platform', $this->permissionsGroupName(), self::CREATE_MODE),
                self::VIEW_MODE => implodeWithDot('platform', $this->permissionsGroupName(), self::VIEW_MODE),
                self::STATUS_CHANGE_ACTION => implodeWithDot('platform', $this->permissionsGroupName(), self::STATUS_CHANGE_ACTION),
                self::DELETE_ACTION => implodeWithDot('platform', $this->permissionsGroupName(), self::DELETE_ACTION),
            ];
        }*/

    public function __construct()
    {
        parent::__construct();
        $this->initPermission()->setMode('default');

    }

    public function mergeWithCrudElements(array $elements):array
    {
        return array_merge($this->crudElementsArray(),$elements);
    }



    public function crudElementsArray(): array
    {
        $data = $this->getMode() === self::COLLECTION_MODE ?
            [KlorchidListLayout::getScreenQueryCollectionKeyname() => $this->collectionQuery()->filters()->defaultSort('updated_at', 'desc')->paginate()] :
            [KlorchidCrudFormLayout::getScreenQueryModelKeyname() => $this->getModel()];

        \Debugbar::info($this->getMode());
        return array_merge([
            'actionRouteNames'=>$this->actionRouteNames,
            self::$screen_query_mode_keyname => $this->getMode(),
        ], $data);
    }

    public function isRouteWithEntityParam(): bool
    {
        return count(request()->route()->parameterNames) > 1;
    }

    /**
     * @throws \Exception
     */
    public function getRouteEntityParamName()
    {
        if ($this->isRouteWithEntityParam()) {
            return request()->route()->parameterNames[0];
        } else {
            throw new \Exception(self::class . ' There is not a route param to retrieve for the crud screen');
        }
    }

    /**
     * @throws \Exception
     */
    public function getRouteEntityParamValue()
    {
        return request()->route($this->getRouteEntityParamName());
    }

    public function detectMode(): string
    {
        $mode = 'default';
        $action_from_route = $this->getActionFromCurrentRoute();


        if ($action_from_route === self::EDIT_MODE && empty($this->getRouteEntityParamValue())) {
            $mode = self::CREATE_MODE;
        }

        if ($action_from_route === self::EDIT_MODE && !empty($this->getRouteEntityParamName())) {
            $mode = self::VIEW_MODE;
        }
        //dd($action_from_route === self::EDIT_MODE , !empty($this->getRouteEntityParamValue()) , $this->loggedUserHasActionPermission(self::EDIT_MODE));
        if ($action_from_route === self::EDIT_MODE && !empty($this->getRouteEntityParamValue()) && $this->loggedUserHasActionPermission(self::EDIT_MODE)) {
            $mode = self::EDIT_MODE;
        }

        if ($action_from_route === self::COLLECTION_MODE) {
            $mode = $action_from_route;
        }


        return $mode;

    }

    public
    function blamingFieldsQuery(Builder $query): Builder
    {
        return $query->with(['creator', 'updater'])
            ->addSelect('created_by', 'updated_by');
    }

    /**
     * @throws \Exception
     */
    public
    function commandBarElements(): array
    {

        //$this->getSaveButton()
        //->canSee($this->loggedUserHasActionPermission("edit") or $this->loggedUserHasActionPermission("create"));
        $this->getCommandBarElements()->add(
            Link::make(__("Add"))
                ->icon('add')
                ->canSee($this->getMode() === self::COLLECTION_MODE)
                ->route($this->getRouteNameFromAction(self::EDIT_MODE))
        );

        return [

        ];
    }


    public
    function defaultModeLayout(): array
    {
        return [];
    }

    abstract function editModeLayout(): array;

    abstract function listModeLayout(): array;

    public function createModeLayout(): array
    {
        return $this->editModeLayout();
    }

    public function viewModeLayout(): array
    {
        return $this->editModeLayout();
    }


}
