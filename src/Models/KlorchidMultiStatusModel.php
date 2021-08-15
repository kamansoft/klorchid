<?php


namespace Kamansoft\Klorchid\Models;


use Kamansoft\Klorchid\Models\Contracts\KlorchidMultiStatusModelInterface;
use Kamansoft\Klorchid\Models\Traits\KlorchidModelsExtraAppendTrait;
use Kamansoft\Klorchid\Models\Traits\KlorchidMultiStatusModelTrait;
use Kamansoft\Klorchid\Models\Contracts\KlorchidModelsExtraAppendInterface;


abstract class KlorchidMultiStatusModel extends KlorchidEloquentModel implements KlorchidModelsExtraAppendInterface, KlorchidMultiStatusModelInterface
{
    use KlorchidModelsExtraAppendTrait;
    use KlorchidMultiStatusModelTrait;

    protected array $multi_status_extra_appends = [
        'statusName'
    ];

    public function __construct(array $attributes = [])
    {
        $this->setExtraAppends();
        parent::__construct($attributes);
    }
}