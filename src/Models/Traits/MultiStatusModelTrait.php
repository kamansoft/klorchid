<?php


namespace Kamansoft\Klorchid\Models\Traits;


trait MultiStatusModelTrait
{

    public function getDisabledStatusValue(){
        return static::disabledStatusValue();
    }

     public function statusSet($status, string $reason): self
    {

        $this->status = $status;
        $this->cur_status_reason = $reason;
        $this->save();
        return $this;
    }

    public function getStringStatusAttribute(): string
    {
        return self::statusToString($this->status);
    }

    static function statusToString($status): string
    {
        $values = static::statusValues();

        $statusName = array_search(strval(intval($status)), $values);
        if (!$statusName){
            throw new \Exception("status name for $status status value not found on statusNameValues model's method returned array  ");
        }
        //$statusName = $values[strval(intval($status))];
        return $statusName;
    }




}