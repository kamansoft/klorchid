<?php


namespace Kamansoft\Klorchid\Models\Traits;


use Kamansoft\Klorchid\Layouts\Traits\MultiStatusModelLayoutTrait;

trait BooleanStatusModelTrait
{
    use KlorchidMultiStatusModelTrait;

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

    static function statusColorClasses(): array
    {
        return [
            'inactive'=>'text-danger',
            'active'=>'text-success'
        ];
    }




    static function getStatusName(bool $status): string
    {
        $status = self::statusValues();
        return array_search($status, $status);
    }




}