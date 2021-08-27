<?php


namespace Kamansoft\Klorchid\Models\Traits;


use Illuminate\Support\Facades\Log;
use Kamansoft\Klorchid\Models\Presenters\MultiStatusModelPresenter;

/**
 *
 * @const  array NAME_VALUE_STATUS_MAP
 */
trait  KlorchidMultiStatusModelTrait
{

    public function getStatusColorClass($status_value = null): string
    {
        try {
            $status = is_null($status_value) ? $this->status : $status_value;
            return array_search($status, static::CLASS_NAME_STATUS_VALUE_MAP, true);
        } catch (\Exception $e) {
            log::warning(static::class . ' Unable to get the css class for the (' . $status_value . ') status value of the element with '.$this->getKeyName().': '.$this->getKey().' empty string will be returned .  - ' . $e->getMessage());
        }
        return '';
    }

    public function statusSet($status, string $reason): bool
    {

        $this->status = $status;
        $this->cur_status_reason = $reason;
        return $this->save();

    }

    public function getStatusNameAttribute(): string
    {
        //$this->checkNameValueStatusMap();
        $status = $this->status;
        return __(array_search($status, static::NAME_VALUE_STATUS_MAP, true));
    }


    /*
    public function checkNameValueStatusMap()
    {
        $class  = static::class;
        $constant  = $class.'self::NAME_VALUE_STATUS_MAP';
        if (!defined('self::NAME_VALUE_STATUS_MAP') && empty(static::NAME_VALUE_STATUS_MAP)) {
            $message = self::class . ':  A non empty constant array  "NAME_VALUE_STATUS_MAP" was not found or is empty at: ' . static::class;
            Log::error($message);
            throw new \Exception($message);
        }
    }*/

    public function isLockedByStatus($status_value = null): bool
    {
        try {

            $status = is_null($status_value) ? $this->status : $status_value;
            return in_array($status, static::EDIT_LOCKED_STATUS_VALUES, true);
        } catch (\Exception $e) {
            log::warning(static::class . ' Unable to deternminate if status: (' . $status . ') of elementof the element with '.$this->getKeyName().': ('.$this->getKey().') is locked to edit, a false value has been returned from isLockedByStatus .  - ' . $e->getMessage());
        }
        return false;
    }

    public function statusPresenter(): MultiStatusModelPresenter
    {
        return new MultiStatusModelPresenter($this);
    }


}
