<?php


namespace Kamansoft\Klorchid\Models\Traits;


trait BinaryStatusModelsTrait
{
    use KlorchidModelsStatusTrait;
    use KlorchidUserBlamingModelsTrait;
    use KlorchidEloquentModelsTrait;
    use KlorchidModelsStatusValuesTrait;

    static public function stringToStatus(string $status):bool
    {
        $values = self::statusStringValues();
        return boolval(intval($values[$status]));
    }
    public function statusToggle(string $reason)
    {
         $this->statusSet(!$this->status, $reason);
         return $this;
    }
    static public function statusStringValues():array
    {
        return [
             __('Inactive')=>'0',
             __('Active') => '1'

        ];
    }

}