<?php


namespace Kamansoft\Klorchid\Models\Traits;


use Kamansoft\Klorchid\Layouts\Traits\MultiStatusModelLayoutTrait;

trait BooleanStatusModelTrait
{
    use StatusModelTrait;

    protected $boolean_status_extra_casts = [
        'status' => 'boolean'
    ];

    static function lockedStatuses(): array
    {
        return [false];
    }


    static function statusValues(): array
    {
        return [
            'inactive' => false,
            'active' => true,
        ];
    }




    static function getStatusName(bool $status): string
    {
        //$names = array_flip(static::statusValues());
        $status = self::statusValues();
        return array_search($status, $status);
        /*
        $name = array_search($status,$status);
        if ($name){
            return $name;
        }else{
            throw new \Exception("status name for ".strval($status)." status value not found on statusNameValues model's method returned array  ");
        }*/

    }




}