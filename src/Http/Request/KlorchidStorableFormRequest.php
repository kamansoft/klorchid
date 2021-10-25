<?php

namespace Kamansoft\Klorchid\Http\Request;

use App\Models\Tanatory;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Mix;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;
use Kamansoft\Klorchid\Contracts\KlorchidModelRelationLoadbleInterface;
use Kamansoft\Klorchid\Contracts\KlorchidMultimodeInterface;
use Kamansoft\Klorchid\Contracts\KlorchidPermissionsInterface;
use Kamansoft\Klorchid\Layouts\KlorchidCrudFormLayout;
use Kamansoft\Klorchid\Models\KlorchidEloquentModel;
use Kamansoft\Klorchid\Support\Facades\Notificator;
use Kamansoft\Klorchid\Traits\KlorchidModelRelationLoadbleTrait;
use Kamansoft\Klorchid\Traits\KlorchidMultiModeTrait;
use Kamansoft\Klorchid\Traits\KlorchidPermissionsTrait;


abstract class KlorchidStorableFormRequest extends EntityDependantFormRequest
    implements KlorchidPermissionsInterface, KlorchidMultimodeInterface, KlorchidModelRelationLoadbleInterface
{
    use KlorchidMultiModeTrait;
    use KlorchidPermissionsTrait;
    use KlorchidModelRelationLoadbleTrait;


    const MODES_METHODS_NAME_SUFFIX = 'authorizeModeOn';
    const CREATE_ACTION_NAME = 'create';
    const EDIT_ACTION_NAME = 'edit';


    public function __construct(array $query = [], array $request = [], array $attributes = [], array $cookies = [], array $files = [], array $server = [], $content = null)
    {
        $this->initAvailableModes(self::MODES_METHODS_NAME_SUFFIX);
        parent::__construct($query, $request, $attributes, $cookies, $files, $server, $content);
    }

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        //dd($this->detectMode());
        $this->setMode($this->detectMode());
        $mode_method_name = $this->getModeMethod($this->getMode());
        return $this->$mode_method_name();
    }

    public function detectMode()
    {

        $model = $this->getModelFromRoute();

        if (!is_null($model) && property_exists($model, 'exists') && $model->exists) {
            return self::EDIT_ACTION_NAME;
        }

        return self::CREATE_ACTION_NAME;

    }

    public function checkCreatePermission(?string $create_permission = null)
    {
        if (empty($create_permission)) {
            //check premission directly from class attribute
            if (!empty(static::CREATE_PERMISSION)) {
                return $this->loggedUserHasPermission(static::CREATE_PERMISSION);
            }
            //guessing the premition using the permition group
            if (!empty($this->permissions_group)) {
                return $this->loggedUserHasPermission(implodeWithDot($this->permissions_group, self::CREATE_ACTION_NAME));
            }

            throw new \Exception(self::class . '::checkCreatePermission() method is unable to determinate the 
            permission needed to run the request. You may declare the static create permission const  "CREATE_PERMISSION" with a value  at: ' . static::class . ' class');
        } else {
            return $this->loggedUserHasPermission($create_permission);
        }
    }

    public function checkEditPermission(?string $edit_permission = null)
    {
        if (empty($edit_permission)) {
            //check premission directly from class attribute
            if (!empty(static::EDIT_PERMISSION)) {
                return $this->loggedUserHasPermission(static::EDIT_PERMISSION);
            }
            //guessing the premition using the permition group
            if (!empty($this->permissions_group)) {
                return $this->loggedUserHasPermission(implodeWithDot($this->permissions_group, self::EDIT_ACTION_NAME));
            }
            throw new \Exception(self::class . '::checkEditPermission() method is unable to determinate the permission needed to run the request.
             You may declare the static edit  permission const "EDIT_PERMISSION" with a value at: ' . static::class . ' class');
        } else {
            return $this->loggedUserHasPermission($edit_permission);
        }
    }

    /**
     * Performs a common tasks that include notification on update or create a new item
     *
     * @param Model $model to fill with data
     * @param string|array $data_to_store if a string it will be taken as the keyname of the request inputs values subset
     * to fill the model with. If is an array it will be taken as the values to fill the model with.
     * @return bool
     */
    public function store(Model $model, $data_to_store = null): bool
    {
        Notificator::setMode("alert");
        $isUpdating = $model->exists;
        if (is_string($data_to_store) && !is_null($this->get($data_to_store))) {

            $data_to_store = $this->get($data_to_store);
            //} elseif (!is_array($data_to_store)) {

        } elseif (is_null($data_to_store) && count($this->rules()) > 0) {
            $data_to_store = $this->validated();

        } elseif (is_null($data_to_store)) {
            $data_to_store = $this->getCrudFormData();
        }
        $save_performed = $model->fill($data_to_store)->save();

        $message_data = [
            'element' => __($this->entityRouteParamName()),
        ];

        if ($save_performed) {
            $message = $isUpdating ?
                __('Success on Updating :element', $message_data) :
                __('Success on Creating :element', $message_data);
            Notificator::success($message);
            Log::info($message . ' record primary key: ' . $model->getKey());
        } else {
            $message = __('Unable to save element :element', $message_data);
            Notificator::error($message);
            Log::warning($message . ' record primary key: ' . $model->getKey());
        }
        return $save_performed;
    }

    public function getCrudFormData(){
        return $this->get(KlorchidCrudFormLayout::getScreenQueryModelKeyname());
    }

    public function rules(): array
    {
        return empty($this->all()) ? [] : $this->validationRules();
    }

    //abstract public function validationRules(Model $model): array;

    abstract public function authorizeModeOnCreate();

    abstract public function authorizeModeOnEdit();

    /**
     * Maps thorough thereflectionClass object of an instance of this class,
     * get all the methods which name's ends with the value at $needle
     * and returns a collection with all of those methods
     * @param string $needle
     * @return Collection
     * @throws \ReflectionException
     */
    private function getModesByMethodsName(string $needle = 'Mode'): Collection
    {
        return getObjectMethodsThatStartsWith($this, $needle);
    }

}
