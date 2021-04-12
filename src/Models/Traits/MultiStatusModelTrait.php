<?php


namespace Kamansoft\Klorchid\Models\Traits;


use Illuminate\Support\Collection;

trait  MultiStatusModelTrait
{

    public function getDisabledStatusValue()
    {
        return static::disabledStatusValue();
    }

    static function getStatusColors(): Collection
    {
        return self::statusColors();
    }

    public function getStatusColor($param)
    {
        return self::getStatusColors()->get($param);
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


}
