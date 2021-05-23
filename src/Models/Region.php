<?php

namespace App\Models;


use Datakrama\Eloquid\Traits\Uuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Kamansoft\Klorchid\Models\Country;
use Kamansoft\Klorchid\Models\KlorchidBooleanStatusModel;
use Kamansoft\Klorchid\Models\State;
use Orchid\Filters\Filterable;
use Orchid\Screen\AsSource;

class Region extends KlorchidBooleanStatusModel
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
    protected $table = 'regions';

    protected $primaryKey = 'id';

    protected $attributes = [
        'status' => True
    ];

    protected $fillable = [
        'country_id',
        'state_id',
        'name'
    ];

    protected $allowedFilters = [
        'country_id',
        'state_id',
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
        'country_id',
        'state_id',
        'name',
        'updated_at',
        'updated_by',
        'created_at',
        'created_by',
        'status'

    ];

    protected $appends = [
        'statusName'
    ];

    public function country()
    {
        return $this->belongsTo(Country::class);
    }

    public function states()
    {
        return $this->hasMany(State::class);
    }


}
