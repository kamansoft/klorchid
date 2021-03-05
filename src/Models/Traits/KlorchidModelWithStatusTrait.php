<?php


namespace Kamansoft\Klorchid\Models\Traits;


use Barryvdh\LaravelIdeHelper\Eloquent;

trait KlorchidModelWithStatusTrait
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
        $this->status = false;
        $this->save();
        return $this;
    }

    public function getStringStatusAttribute(): string
    {
        //dd(self::statusStringValues());
        return self::statusToString($this->status);

        //return array_search(strval(intval($this->status)), $string_values);
    }

    static public function statusToString($status): string
    {

        $string_values = self::statusStringValues();
        return __(array_search(strval(intval($status)), $string_values));
    }




}
