<?php


namespace Kamansoft\Klorchid\Models;


use Kamansoft\Klorchid\Models\Contracts\BooleanStatusModelInterface;
use Kamansoft\Klorchid\Models\Traits\BooleanStatusModelTrait;

class KlorchidBooleanStatusModel extends KlorchidMultiStatusModel implements BooleanStatusModelInterface
{
    use BooleanStatusModelTrait;


    public const NAME_VALUE_STATUS_MAP = [
        'active' => true,
        'inactive' => false
    ];

    public const EDIT_LOCKED_STATUS_VALUES = [
        false
    ];

    public const CLASS_NAME_STATUS_VALUE_MAP = [
        'danger'=>false,
        'success' => true
    ];
}