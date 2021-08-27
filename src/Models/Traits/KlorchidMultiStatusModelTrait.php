<?php


namespace Kamansoft\Klorchid\Models\Traits;


use Kamansoft\Klorchid\Models\Presenters\MultiStatusModelPresenter;

/**
 *
 * @const  array NAME_VALUE_STATUS_MAP
 */
trait  KlorchidMultiStatusModelTrait
{

    public function getStatusColorClass($status_value = null): string
    {
        $status = is_null($status_value) ? $this->status : $status_value;
        return array_search($status, static::CLASS_NAME_STATUS_VALUE_MAP, true);
    }

    public function statusSet($status, string $reason): bool
    {

        $this->status = $status;
        $this->cur_status_reason = $reason;
        return $this->save();

    }

    public function getStatusNameAttribute(): string
    {

        $status = $this->status;
        return __(self::getStatusName($status));
    }

    public static function getStatusName($status)
    {
        return array_search($status, static::NAME_VALUE_STATUS_MAP, true);
    }

    public function isLockedByStatus($status_value = null): bool
    {

        $status = is_null($status_value) ? $this->status : $status_value;
        return in_array($status, static::EDIT_LOCKED_STATUS_VALUES, true);
    }

    public function statusPresenter(): MultiStatusModelPresenter
    {
        return new MultiStatusModelPresenter($this);
    }


}
