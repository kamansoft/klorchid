<?php


namespace Kamansoft\Klorchid\Models\Traits;


use Barryvdh\LaravelIdeHelper\Eloquent;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Model;

trait KlorchidModelsStatusTrait
{
    static public function statusStringValues():array
    {
        //this is odd and ugly but the best i can
        return [
             __('Disable')=>'0',
             __('Enabled') => '1'

        ];
    }


    public function getStringStatusAttribute():string
    {
        return $this::statusToString($this->status > 0);
    }

    static public function statusToString(bool $status):string
    {
        $string_values = self::statusStringValues();
        return array_search(strval(intval($status)), $string_values);
    }

    static public function stringToStatus(string $status):bool
    {
        $values = self::statusStringValues();
        return boolval(intval($values[$status]));
    }







    public function statusSet(bool $status, string $reason):self
    {

        $this->status = $status;
        $this->cur_status_reason = $reason;
        $this->save();
        return $this;
    }

    public function statusToggle(string $reason):self
    {
        return $this->statusSet(!$this->status, $reason);

    }

    public function invalidate():self
    {
        $this->status = false;
        $this->save();
        return $this;
    }

}
