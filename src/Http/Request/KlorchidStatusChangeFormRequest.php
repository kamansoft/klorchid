<?php


namespace Kamansoft\Klorchid\Http\Request;


use Kamansoft\Klorchid\Contracts\KlorchidPermissionsInterface;
use Kamansoft\Klorchid\Models\KlorchidEloquentModel;
use Kamansoft\Klorchid\Models\KlorchidMultiStatusModel;
use Kamansoft\Klorchid\Screens\KlorchidCrudScreen;
use Kamansoft\Klorchid\Support\Facades\Notificator;
use Kamansoft\Klorchid\Traits\KlorchidPermissionsTrait;
use Kamansoft\Klorchid\Layouts\KlorchidCrudFormLayout;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Log;

/**
 * Class KlorchidStatusChangeFormRequest
 * @package Kamansoft\Klorchid\Http\Request
 * @method KlorchidMultiStatusModel getModel()
 */
abstract class KlorchidStatusChangeFormRequest extends EntityDependantFormRequest
    implements KlorchidPermissionsInterface
{
    use KlorchidPermissionsTrait;

    public function authorize()
    {

        return $this->loggedUserHasPermission(implodeWithDot(
            'platform',
            $this->entityRouteParamName(),
            'status_change'));

    }


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
            Log::info('Succes on status change on ' . $this->entityRouteParamName().' to status: '.
                KlorchidCrudFormLayout::fullFormInputAttributeName('new_status') . '  with pk: ' .
                $model->getKey());

        } else {
            Notificator::success(__('Error on new status set'));
            Log::info('status change error on ' . $this->entityRouteParamName().' to status: '.
                KlorchidCrudFormLayout::fullFormInputAttributeName('new_status') . '  with pk: ' .
                $model->getKey());
        }

        return $change_executed;
    }


}