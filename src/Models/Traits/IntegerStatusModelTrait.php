<?php


namespace Kamansoft\Klorchid\Models\Traits;


trait IntegerStatusModelTrait
{
    use StatusModelTrait;

    protected $integer_status_extra_casts = [
        'status' => 'integer'
    ];


    static function getStatusName(int $status): string
    {
        $names = array_flip(static::statusValues());
        if (array_key_exists($status, $names)) {
            return $names[$status];
        } else {
            throw new \Exception("status name for $status status value not found on statusNameValues model's method returned array  ");
        }

    }

}