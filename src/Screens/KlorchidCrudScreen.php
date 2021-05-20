<?php

namespace Kamansoft\Klorchid\Screens;

use App\Http\Requests\KlorchidTestStorableFormRequest;
use App\Klorchid\Layouts\KlorchidTestCrudFormLayout;
use App\Models\KlorchidTest;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Kamansoft\Klorchid\Contracts\KlorchidPermissionsInterface;
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
use Kamansoft\Klorchid\Screens\Traits\KlorchidStatusChangeFormRequest;
use Kamansoft\Klorchid\Screens\Traits\SaveCommandTrait;
use Kamansoft\Klorchid\Screens\Traits\StatusChangeCommandTrait;
use Kamansoft\Klorchid\Traits\KlorchidMultiModeTrait;
use Kamansoft\Klorchid\Traits\KlorchidPermissionsTrait;
use Orchid\Screen\Action;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Dashboard;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Fields\Input;
use Orchid\Support\Facades\Alert;
use Orchid\Support\Facades\Layout;
use Illuminate\Database\Eloquent\Builder;

//class KlorchidTestScreen extends KlorchidMultiModeScreen
abstract class KlorchidCrudScreen extends KlorchidMultiModeScreen
    implements KlorchidPermissionsInterface, KlorchidScreensPermissionsInterface, SaveCommandInterface,
    StatusChangeCommandInterface, KlorchidScreensCommandBarElementsInterface
{

    use KlorchidPermissionsTrait;
    use KlorchidScreensPermissionsTrait;
    use StatusChangeCommandTrait;
    use SaveCommandTrait;
    use KlorchidCrudScreensCommandBarElementsTrait;

    public static string $screen_query_model_keyname = 'model';
    const COLLECTION_MODE='list';
    const CREATE_MODE='create';
    const EDIT_MODE='edit';
    const VIEW_MODE='view';
    const DELETE_ACTION = 'delete';
    const STATUS_CHANGE_ACTION = 'status_change';

    abstract public function permissionsGroupName(): string;
    abstract public function collectionQuery();

    public function actionPermissionsMap(): array
    {
        return [
            self::COLLECTION_MODE => implodeWithDot('platform', $this->actionPermissionsMap(), self::COLLECTION_MODE),
            self::EDIT_MODE => implodeWithDot('platform', $this->actionPermissionsMap(), self::EDIT_MODE),
            self::CREATE_MODE => implodeWithDot('platform', $this->actionPermissionsMap(), self::CREATE_MODE),
            self::VIEW_MODE => implodeWithDot('platform', $this->actionPermissionsMap(), self::VIEW_MODE),
            self::STATUS_CHANGE_ACTION => implodeWithDot('platform', $this->actionPermissionsMap(), self::STATUS_CHANGE_ACTION),
            self::DELETE_ACTION => implodeWithDot('platform', $this->actionPermissionsMap(), self::DELETE_ACTION),
        ];
    }

    public function blamingFieldsQuery(Builder $query): Builder
    {
		return $query->with(['creator', 'updater'])
			->addSelect('created_by', 'updated_by');
	}


    public function commandBarElements(): array
    {

        //$this->getSaveButton()
        //->canSee($this->loggedUserHasActionPermission("edit") or $this->loggedUserHasActionPermission("create"));
        return [

        ];
    }

    public function defaultModeLayout(): array
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
