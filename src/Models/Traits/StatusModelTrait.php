<?php


namespace Kamansoft\Klorchid\Models\Traits;


use Illuminate\Support\Collection;
use Kamansoft\Klorchid\Models\Presenters\MultiStatusModelPresenter;

trait  StatusModelTrait
{

    public function statusSet($status, string $reason): self
    {

        $this->status = $status;
        $this->cur_status_reason = $reason;
        $this->save();
        return $this;
    }


    public function getStatusNameAttribute(): string
    {
        $status = $this->status;
        return self::getStatusName($status);
    }

    public function isLockedByStatus(?string $status = null): bool
    {
        $status = $status || $this->status;
        return in_array($status, $this::lockedStatuses());
    }

    public function statusPresenter()
    {
        return new MultiStatusModelPresenter($this);
    }

}
