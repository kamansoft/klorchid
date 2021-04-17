<?php


namespace Kamansoft\Klorchid\Models\Traits;



trait StringStatusModelTrait
{

    use StatusModelTrait;


        protected $string_status_extra_casts = [
        'status' => 'string'
    ];

    static function getStatusName(string $status): string
    {
        $names = array_flip(static::statusValues());
        if (in_array($status,$names)){
            return $names[$status];
        }else{
            throw new \Exception("status name for $status status value not found on statusNameValues model's method returned array  ");
        }

    }
}