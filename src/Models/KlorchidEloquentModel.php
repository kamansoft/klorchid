<?php

namespace Kamansoft\Klorchid\Models;

//use Datakrama\Eloquid\Traits\Uuids;
use Illuminate\Database\Eloquent\Model;
use Kamansoft\Klorchid\Models\Contracts\KlorchidModelExtraCastInterface;
use Kamansoft\Klorchid\Models\Contracts\KlorchidModelsInterface;
use Kamansoft\Klorchid\Models\Contracts\KlorchidUserBlamingModelInterface;
use Kamansoft\Klorchid\Models\Contracts\PkPresentableInterface;
use  Kamansoft\Klorchid\Models\Traits\KlorchidUserBlamingModelsTrait;
use Kamansoft\Klorchid\Models\Traits\KlorchidModelsExtraCastTrait;
use Kamansoft\Klorchid\Models\Traits\PkPresentableTrait;


class KlorchidEloquentModel extends Model implements KlorchidModelExtraCastInterface, KlorchidModelsInterface, KlorchidUserBlamingModelInterface, PkPresentableInterface

{

    use KlorchidUserBlamingModelsTrait;
    use KlorchidModelsExtraCastTrait;
    use PkPresentableTrait;
    //use Uuids;
    /**
     * @throws \ReflectionException
     */
    public function __construct(array $attributes = [])
    {
        $this->setCasts();
        parent::__construct($attributes);
    }
    protected $time_extra_casts = [

        'updated_at' => 'datetime:d/m/Y h:m:s a',
        'created_at' => 'datetime:d/m/Y h:m:s a',

    ];
}