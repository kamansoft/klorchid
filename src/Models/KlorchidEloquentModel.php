<?php

namespace Kamansoft\Klorchid\Models;

//use Datakrama\Eloquid\Traits\Uuids;
use Illuminate\Database\Eloquent\Model;
use Kamansoft\Klorchid\Models\Contracts\BlamingPrensentableInterface;
use Kamansoft\Klorchid\Models\Contracts\KlorchidModelExtraCastInterface;
use Kamansoft\Klorchid\Models\Contracts\KlorchidModelsExtraAppendInterface;
use Kamansoft\Klorchid\Models\Contracts\KlorchidModelsInterface;
use Kamansoft\Klorchid\Models\Contracts\KlorchidUserBlamingModelInterface;
use Kamansoft\Klorchid\Models\Contracts\PkPresentableInterface;
use Kamansoft\Klorchid\Models\Traits\BlamingPresentableTrait;
use Kamansoft\Klorchid\Models\Traits\KlorchidModelsExtraAppendTrait;
use Kamansoft\Klorchid\Models\Traits\KlorchidModelsExtraCastTrait;
use Kamansoft\Klorchid\Models\Traits\KlorchidUserBlamingModelsTrait;
use Kamansoft\Klorchid\Models\Traits\PkPresentableTrait;


class KlorchidEloquentModel extends Model implements BlamingPrensentableInterface, KlorchidModelExtraCastInterface, KlorchidModelsExtraAppendInterface, KlorchidModelsInterface, KlorchidUserBlamingModelInterface, PkPresentableInterface

{

    use BlamingPresentableTrait;
    use KlorchidUserBlamingModelsTrait;
    use KlorchidModelsExtraAppendTrait;
    use KlorchidModelsExtraCastTrait;
    use PkPresentableTrait;

    //use Uuids;

    protected $time_extra_casts = [

        'updated_at' => 'datetime:d/m/Y h:m:s a',
        'created_at' => 'datetime:d/m/Y h:m:s a',

    ];

    /**
     * @throws \ReflectionException
     */
    public function __construct(array $attributes = [])
    {
        $this
            ->setCasts()//automatic add to casts all other attributes that ends with extra_casts
            ->setExtraAppends();//automatic add to appends all other attributes that ends with extra_appends
        parent::__construct($attributes);
    }
}