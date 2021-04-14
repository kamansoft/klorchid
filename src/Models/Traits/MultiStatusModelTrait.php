<?php


namespace Kamansoft\Klorchid\Models\Traits;


use Illuminate\Support\Collection;
use Kamansoft\Klorchid\Models\Presenters\MultiStatusModelPresenter;

trait  MultiStatusModelTrait
{

    public function getDisabledStatusValues()
    {
        return [];
    }


    public function statusSet($status, string $reason): self
    {

        $this->status = $status;
        $this->cur_status_reason = $reason;
        $this->save();
        return $this;
    }

    public function getStatusNameAttribute(): string
    {
        return self::statusToString($this->status);
    }

    static function statusToString($status): string
    {
        $values = static::statusValues();

        $statusName = array_search(strval(intval($status)), $values);
        if (!$statusName) {
            throw new \Exception("status name for $status status value not found on statusNameValues model's method returned array  ");
        }
        //$statusName = $values[strval(intval($status))];
        return $statusName;
    }

    public function isLockedByStatus(?string $status = null): bool
    {
        $status = $status || $this->status;
        return !in_array($status, $this::lockedStatus());
    }

    public function statusPresenter()
    {
        return new MultiStatusModelPresenter($this);
    }

}
