<?php


namespace Kamansoft\Klorchid\Models\Traits;


use Kamansoft\Klorchid\Layouts\Traits\MultiStatusModelLayoutTrait;

trait BooleanStatusModelTrait
{
    use KlorchidMultiStatusModelTrait;

    protected $boolean_status_extra_casts = [
        'status' => 'boolean'
    ];

}