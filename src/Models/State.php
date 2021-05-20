<?php

namespace Kamansoft\Klorchid\Models;


use Datakrama\Eloquid\Traits\Uuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Kamansoft\Klorchid\Models\Country;
use Kamansoft\Klorchid\Models\KlorchidBooleanStatusModel;
use Orchid\Filters\Filterable;
use Orchid\Screen\AsSource;

class State extends KlorchidBooleanStatusModel
{
    use AsSource;
    use Filterable;

    //use HasFactory;
    use Uuids;

    /*
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'states';

    protected $primaryKey = 'id';

    protected $attributes = [
        'status' => True
    ];

    protected $fillable = [
        'name',
        'country_id'
    ];

    protected $allowedFilters = [
        'name',
        'updated_at',
        'updated_by',
        'created_at',
        'created_by',
        'status'

    ];
    /**
     * @var array
     */
    protected $allowedSorts = [
        'name',
        'updated_at',
        'updated_by',
        'created_at',
        'created_by',
        'status'

    ];

    protected $appends = [
        'statusName',

    ];

    public function country(){
         return $this->belongsTo(Country::class);
    }

}
