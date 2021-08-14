<?php

namespace Kamansoft\Klorchid\Http\Request;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;
use Kamansoft\Klorchid\Contracts\KlorchidMultimodeInterface;
use Kamansoft\Klorchid\Contracts\KlorchidPermissionsInterface;
use Kamansoft\Klorchid\Layouts\KlorchidCrudFormLayout;
use Kamansoft\Klorchid\Support\Facades\Notificator;
use Kamansoft\Klorchid\Traits\KlorchidMultiModeTrait;
use Kamansoft\Klorchid\Traits\KlorchidPermissionsTrait;


abstract class KlorchidStorableFormRequest extends EntityDependantFormRequest
    implements KlorchidPermissionsInterface, KlorchidMultimodeInterface
{
    use KlorchidPermissionsTrait;
    use KlorchidMultiModeTrait;

    const CREATE_ACTION_NAME = 'create';
    const EDIT_ACTION_NAME = 'edit';


    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return $this->getMode()==self::CREATE_ACTION_NAME?$this->checkCreatePermission():$this->checkEditPermission();

    }


    public function checkCreatePermission(?string $create_permission = null)
    {
        if (empty($create_permission)) {
            //check premission directly from class attribute
            if (!empty($this->create_permission)) {
                return $this->loggedUserHasPermission($this->create_permission);
            }
            //guessing the premition using the permition group
            if (!empty($this->permissions_group)) {
                return $this->loggedUserHasPermission(implodeWithDot($this->permissions_group, self::CREATE_ACTION_NAME));
            }
            throw new \Exception(self::class . '::checkCreatePermission() method is unable to determinate the permission needed to run the request, you may specify the status change permission attribute ("$create_permission") at: ' . static::class . ' class');
        } else {
            return $this->loggedUserHasPermission($create_permission);
        }
    }

    public function checkEditPermission(?string $edit_permission = null)
    {
        if (empty($edit_permission)) {
            //check premission directly from class attribute
            if (!empty($this->edit_permission)) {
                return $this->loggedUserHasPermission($this->edit_permission);
            }
            //guessing the premition using the permition group
            if (!empty($this->permissions_group)) {
                return $this->loggedUserHasPermission(implodeWithDot($this->permissions_group, self::EDIT_ACTION_NAME));
            }
            throw new \Exception(self::class . '::checkEditPermission() method is unable to determinate the permission needed to run the request, you may specify the status change permission attribute ("$edit_permission") at: ' . static::class . ' class');
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
        if (is_string($data_to_store) and !is_null($this->get($data_to_store))) {
            $data_to_store = $this->get($data_to_store);
        } elseif (!is_array($data_to_store)) {
            $data_to_store = $this->get(KlorchidCrudFormLayout::getScreenQueryModelKeyname());
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


    public function rules(): array
    {
        return empty($this->all()) ? [] : $this->validationRules();
    }

    abstract function validationRules(): array;
}
