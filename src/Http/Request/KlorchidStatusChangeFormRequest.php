<?php


namespace Kamansoft\Klorchid\Http\Request;


use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;
use Kamansoft\Klorchid\Contracts\KlorchidPermissionsInterface;
use Kamansoft\Klorchid\Layouts\KlorchidCrudFormLayout;
use Kamansoft\Klorchid\Models\KlorchidMultiStatusModel;
use Kamansoft\Klorchid\Support\Facades\Notificator;
use Kamansoft\Klorchid\Traits\KlorchidPermissionsTrait;

/**
 * Class KlorchidStatusChangeFormRequest
 * @package Kamansoft\Klorchid\Http\Request
 * @method KlorchidMultiStatusModel getModel()
 */
abstract class KlorchidStatusChangeFormRequest extends EntityDependantFormRequest
    implements KlorchidPermissionsInterface
{
    use KlorchidPermissionsTrait;

    const STATUS_CHANGE_ACTION_NAME = 'status_change';

    public function rules(): array
    {

        return [
            KlorchidCrudFormLayout::fullFormInputAttributeName('new_status_reason') => [
                'required',
                'string',
                Rule::notIn([$this->getModel()->cur_status_reason])
            ]
        ];
    }

    public function statusChange(KlorchidMultiStatusModel $model): bool
    {

        $change_executed = $model->statusSet(
            $this->input(KlorchidCrudFormLayout::fullFormInputAttributeName('new_status')),
            $this->input(KlorchidCrudFormLayout::fullFormInputAttributeName('new_status_reason'))
        );
        if ($change_executed) {
            Notificator::success(__('Success on new status set'));
            Log::info('Succes on status change on ' . $this->entityRouteParamName() . ' to status: ' .
                KlorchidCrudFormLayout::fullFormInputAttributeName('new_status') . '  with pk: ' .
                $model->getKey());
        } else {
            Notificator::success(__('Error on new status set'));
            Log::info('status change error on ' . $this->entityRouteParamName() . ' to status: ' .
                KlorchidCrudFormLayout::fullFormInputAttributeName('new_status') . '  with pk: ' .
                $model->getKey());
        }

        return $change_executed;
    }

    public function authorize()
    {
        return checkStatusChangePermission();
    }

    protected function checkStatusChangePermission(?string $permission = null)
    {

        if (empty($permission)) {
            if (!empty($this->status_change_permission)) {
                return $this->loggedUserHasPermission($this->status_change_permission);
            }
            if (!empty($this->permissions_group)) {
                return $this->loggedUserHasPermission(implodeWithDot($this->permissions_group, self::STATUS_CHANGE_ACTION_NAME));
            }
            throw new \Exception(self::class . '::checkStatusChangePermission() method is unable to determinate the permission needed to run the request, you may specify the status change permission attribute ("$status_change_permission") at: ' . static::class . ' class');
        } else {
            return $this->loggedUserHasPermission($permission);
        }
    }


}