<?php


namespace Kamansoft\Klorchid\Models\Traits;


trait MultiStatusModelTrait
{
     public function statusSet($status, string $reason): self
    {

        $this->status = $status;
        $this->cur_status_reason = $reason;
        $this->save();
        return $this;
    }


    public function invalidate(): self
    {
        $this->status = self::DISABLED_STATUS_VALUE;
        $this->save();
        return $this;
    }

    public function getStringStatusAttribute(): string
    {
        return self::statusToString($this->status);
    }

    static public function statusToString($status): string
    {
        $string_values = self::statusStringValues();
        return __(array_search(strval(intval($status)), $string_values));
    }

}