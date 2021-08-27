<?php


namespace Kamansoft\Klorchid\Models\Presenters;

use Illuminate\Support\Str;

/**
 * Class MultiStatusModelPresenter
 * @package Kamansoft\Klorchid\Models\Presenters
 * @property \Kamansoft\Klorchid\Models\KlorchidMultiStatusModel $entity
 */
class MultiStatusModelPresenter extends \Orchid\Support\Presenter
{


    /**
     * maps through  Models NAME_VALUE_STATUS_MAP constant array flips keys by values and returns it
     * bool to int conversions has been taken in consideration for boolean status based models.
     *
     * This is intended to be used on presentation layer to set the options of a select form control
     * @return array
     */
    public function getOptions(): array
    {
        //$this->entity->checkNameValueStatusMap();
        return collect($this->entity::NAME_VALUE_STATUS_MAP)
            ->mapWithKeys(function ($value, $key) {
                $value = is_bool($value) ? intval($value) : $value;
                return [
                    $value => Str::ucfirst(__($key))
                ];
            })
            ->toArray();
    }

    public function currentStatus(): string
    {
        return Str::ucfirst(__($this->entity->getStatusNameAttribute()));
    }


}