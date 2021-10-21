<?php

namespace Kamansoft\Klorchid\Screens;


use Exception;
use Illuminate\Database\Eloquent\Builder;
use Kamansoft\Klorchid\Contracts\KlorchidActionFromRouteInterface;
use Kamansoft\Klorchid\Http\Request\KlorchidDeleteFormRequest;
use Kamansoft\Klorchid\Http\Request\KlorchidStatusChangeFormRequest;
use Kamansoft\Klorchid\Http\Request\KlorchidStorableFormRequest;
use Kamansoft\Klorchid\Layouts\KlorchidCrudFormLayout;
use Kamansoft\Klorchid\Layouts\KlorchidListLayout;
use Kamansoft\Klorchid\Screens\Contracts\KlorchidModelDependantScreenInterface;
use Kamansoft\Klorchid\Screens\Contracts\KlorchidScreensCommandBarElementsInterface;
use Kamansoft\Klorchid\Screens\Contracts\SaveCommandInterface;
use Kamansoft\Klorchid\Screens\Contracts\StatusChangeCommandInterface;
use Kamansoft\Klorchid\Screens\Traits\KlorchidCrudScreensCommandBarElementsTrait;
use Kamansoft\Klorchid\Screens\Traits\KlorchidModelDependantScreenTrait;
use Kamansoft\Klorchid\Screens\Traits\SaveCommandTrait;
use Kamansoft\Klorchid\Screens\Traits\StatusChangeCommandTrait;
use Kamansoft\Klorchid\Traits\KlorchidActionFromRouteTrait;
use Kamansoft\Klorchid\Traits\KlorchidActionPermissionTrait;
use Kamansoft\Klorchid\Contracts\KlorchidActionPermissionInterface;

//class KlorchidTestScreen extends KlorchidMultiModeScreen
abstract class KlorchidCrudScreen extends  KlorchidMultiModeScreen
    implements KlorchidActionFromRouteInterface, KlorchidActionPermissionInterface, SaveCommandInterface,
    StatusChangeCommandInterface,KlorchidModelDependantScreenInterface, KlorchidScreensCommandBarElementsInterface
{

    use KlorchidActionFromRouteTrait;
    use KlorchidActionPermissionTrait;
    use StatusChangeCommandTrait;
    use SaveCommandTrait;
    use KlorchidModelDependantScreenTrait;
    use KlorchidCrudScreensCommandBarElementsTrait;


    //crud common actions
    const SHOW_LIST_ACTION = 'list';
    const CREATE_ACTION = KlorchidStorableFormRequest::CREATE_ACTION_NAME;
    const EDIT_ACTION = KlorchidStorableFormRequest::EDIT_ACTION_NAME;
    const VIEW_ACTION = 'view';
    const DELETE_ACTION = KlorchidDeleteFormRequest::DELETE_ACTION_NAME;
    const STATUS_CHANGE_ACTION = KlorchidStatusChangeFormRequest::STATUS_CHANGE_ACTION_NAME;

    //crud common modes
    const COLLECTION_MODE = self::SHOW_LIST_ACTION;
    const CREATE_MODE = self::CREATE_ACTION;
    const EDIT_MODE = self::EDIT_ACTION;
    const VIEW_MODE = self::VIEW_ACTION;

    protected static string $screen_query_mode_keyname = 'screen_mode';

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
        $this->checkActionRoutesMapAttribute();


        $query_elements = array_merge([
            self::$screen_query_mode_keyname => $this->getMode(),
            KlorchidCrudFormLayout::getScreenQueryRouteNamesKeyname() => static::$action_route_names_map
        ],
            $this->getMode() === self::COLLECTION_MODE ?
                [KlorchidListLayout::getScreenQueryCollectionKeyname() => $this->collectionQuery()->filters()->defaultSort('updated_at', 'desc')->paginate()] :
                [KlorchidCrudFormLayout::getScreenQueryModelKeyname() => $this->getModel()]
        );


        return $query_elements;
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
     * @throws Exception
     */
    public function getRouteEntityParamName()
    {
        if ($this->isRouteWithEntityParam()) {
            return request()->route()->parameterNames[0];
        }

        throw new Exception(self::class . ' There is not a route param to retrieve for the crud screen');
    }

    public function isRouteWithEntityParam(): bool
    {
        return count(request()->route()->parameterNames) > 1;
    }

    /**
     * @throws Exception
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
