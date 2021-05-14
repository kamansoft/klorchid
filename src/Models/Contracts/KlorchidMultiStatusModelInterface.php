<?php


namespace Kamansoft\Klorchid\Models\Contracts;


use Illuminate\Support\Collection;
use Kamansoft\Klorchid\Models\Presenters\MultiStatusModelPresenter;
use Kamansoft\Klorchid\Models\Traits\KlorchidMultiStatusModelTrait;

interface KlorchidMultiStatusModelInterface
{


    /**
     *
     * Should return a keyname value paired array with all the posible status values for a model, example:
     *
     * [
     *      "invalid"=>"0",
     *      "valid"=>"1",
     * ]
     *
     * @return array
     */
    static function statusValues(): array;

    /**
     *
     * A subset of statusValues method returned array (only values) ,
     * To be used by klorchid system in the moment to determinate if the model
     * is able to be edited according its current status
     *
     * @return array the status values to be taken as disabled or locked statues
     */
    static function lockedStatuses(): array;

    public function getStatusNameAttribute(): string;

    public function isLockedByStatus(?string $status = null): bool;

    public function statusSet($status, string $reason): bool;

    /**
     * @return string[]
     */
    static function statusColorClasses(): array;

    public function statusPresenter(): MultiStatusModelPresenter;
}
