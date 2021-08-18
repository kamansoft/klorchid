<?php


namespace Kamansoft\Klorchid\Models\Traits;


use Illuminate\Support\Collection;
use Kamansoft\Klorchid\Models\Presenters\MultiStatusModelPresenter;

trait  KlorchidMultiStatusModelTrait
{

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

    public function isLockedByStatus(?string $status = null): bool
    {
        $status = $status || $this->status;
        return in_array($status, $this::lockedStatuses());
    }

    public function statusPresenter(): MultiStatusModelPresenter
    {
        return new MultiStatusModelPresenter($this);
    }

    static function getStatusColorClass(?string $status_name = null): string
    {
        return array_key_exists($status_name, self::statusColorClasses()) ? self::statusColorClasses()[$status_name] : '';
    }

}
