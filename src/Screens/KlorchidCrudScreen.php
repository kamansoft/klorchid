<?php

namespace Kamansoft\Klorchid\Screens;


use Illuminate\Database\Eloquent\Builder;
use Kamansoft\Klorchid\Http\Request\KlorchidStatusChangeFormRequest;
use Kamansoft\Klorchid\Http\Request\KlorchidStorableFormRequest;
use Kamansoft\Klorchid\Layouts\KlorchidCrudFormLayout;
use Kamansoft\Klorchid\Layouts\KlorchidListLayout;
use Kamansoft\Klorchid\Screens\Contracts\KlorchidScreensCommandBarElementsInterface;
use Kamansoft\Klorchid\Screens\Contracts\KlorchidScreensPermissionsInterface;
use Kamansoft\Klorchid\Screens\Contracts\SaveCommandInterface;
use Kamansoft\Klorchid\Screens\Contracts\StatusChangeCommandInterface;
use Kamansoft\Klorchid\Screens\Traits\KlorchidCrudScreensCommandBarElementsTrait;
use Kamansoft\Klorchid\Screens\Traits\KlorchidScreensPermissionsTrait;
use Kamansoft\Klorchid\Screens\Traits\SaveCommandTrait;
use Kamansoft\Klorchid\Screens\Traits\StatusChangeCommandTrait;

//class KlorchidTestScreen extends KlorchidMultiModeScreen
abstract class KlorchidCrudScreen extends KlorchidMultiModeScreen
    implements KlorchidScreensPermissionsInterface, SaveCommandInterface,
    StatusChangeCommandInterface, KlorchidScreensCommandBarElementsInterface
{


    use KlorchidScreensPermissionsTrait;
    use StatusChangeCommandTrait;
    use SaveCommandTrait;
    use KlorchidCrudScreensCommandBarElementsTrait;


    //action
    const CREATE_ACTION = KlorchidStorableFormRequest::CREATE_ACTION_NAME;
    const EDIT_ACTION = KlorchidStorableFormRequest::EDIT_ACTION_NAME;
    const VIEW_ACTION = 'view';
    const DELETE_ACTION = 'delete';
    const STATUS_CHANGE_ACTION = KlorchidStatusChangeFormRequest::STATUS_CHANGE_ACTION_NAME;

    //modes
    const COLLECTION_MODE = 'list';
    const CREATE_MODE = self::CREATE_ACTION;
    const EDIT_MODE = self::EDIT_ACTION;
    const VIEW_MODE = self::VIEW_ACTION;

    //abstract public function permissionsGroupName(): string;

    public function __construct()
    {
        parent::__construct();
        $this->initPermission()->setMode('default');


    }

    public function mergeWithCrudElements(array $elements): array
    {
        return array_merge($this->crudElementsArray(), $elements);
    }

    public function crudElementsArray(): array
    {
        $data = $this->getMode() === self::COLLECTION_MODE ?
            [KlorchidListLayout::getScreenQueryCollectionKeyname() => $this->collectionQuery()->filters()->defaultSort('updated_at', 'desc')->paginate()] :
            [
                KlorchidCrudFormLayout::getScreenQueryModelKeyname() => $this->getModel(),
                KlorchidCrudFormLayout::getScreenQueryRouteNamesKeyname() => $this->actionRouteNames
            ];


        //\Debugbar::info($this->getMode());
        return array_merge([
            'actionRouteNames' => $this->actionRouteNames,
            self::$screen_query_mode_keyname => $this->getMode(),
        ], $data);
    }

    abstract public function collectionQuery();

    public function detectMode(): string
    {
        $mode = 'default';
        $action_from_route = $this->getActionFromCurrentRoute();


        if ($action_from_route === self::EDIT_MODE && !empty($this->getRouteEntityParamName())) {
            $mode = self::VIEW_MODE;
        }

        if ($action_from_route === self::EDIT_MODE && empty($this->getRouteEntityParamValue())) {
            $mode = self::CREATE_MODE;
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

    public function isRouteWithEntityParam(): bool
    {
        return count(request()->route()->parameterNames) > 1;
    }

    /**
     * @throws \Exception
     */
    public function getRouteEntityParamValue()
    {
        return request()->route($this->getRouteEntityParamName());
    }

    public function blamingFieldsQuery(Builder $query): Builder
    {
        return $query->with(['creator', 'updater'])
            ->addSelect('created_by', 'updated_by');
    }


    public function defaultModeLayout(): array
    {
        return [];
    }

    abstract function editModeLayout(): array;

    abstract function listModeLayout(): array;

    abstract function createModeLayout(): array;

    abstract function viewModeLayout(): array;

}
