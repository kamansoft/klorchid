<?php


namespace Kamansoft\Klorchid\Models\Traits;


trait BinaryStatusModelTrait
{
    static function lockedStatus():array
    {
        return ['0'];
    }


    static function statusValues(): array
    {
        return [
            'inactive' => '0',
            'active' => '1',
        ];
    }






}