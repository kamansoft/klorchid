<?php


namespace Kamansoft\Klorchid\Models\Traits;


trait KlorchidModelsStatusValuesTrait
{
   public function getStringStatusAttribute():string
    {
        //dd(self::statusStringValues());
        return self::statusToString($this->status);

        //return array_search(strval(intval($this->status)), $string_values);
    }

    static public function statusToString($status):string
    {

        $string_values = self::statusStringValues();
        return array_search(strval(intval($status)), $string_values);
    }



}