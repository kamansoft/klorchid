<?php


namespace Kamansoft\Klorchid\Models\Presenters;

use Illuminate\Support\Str;

/**
 * Class MultiStatusModelPresenter
 * @package Kamansoft\Klorchid\Models\Presenters
 * @property
 */
class MultiStatusModelPresenter extends \Orchid\Support\Presenter
{




    /**
     * maps through  Models statusValues array flips it and returns it
     * bool to int conversions has been taken in consideration for boolean status based models
     * @return array
     */
    public function getOptions(): array
    {
        return collect($this->entity::statusValues())
            ->mapWithKeys(function ($value, $key) {
                $value = is_bool($value)?intval($value):value;
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

    /**
     * returns the class for fields based on current status
     * @param string|null $statusName
     * @return mixed
     */
    public function getStatusFieldColorClass(?string $statusName=null){
        $statusName = $statusName || $this->entity->statusName;
        return $this->entity::getStat()[$statusName];
        //return $this->entity::statusColorClasses()[$this->entity->statusName];
    }



}