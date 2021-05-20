<?php

namespace Kamansoft\Klorchid\Models;


use Datakrama\Eloquid\Traits\Uuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Kamansoft\Klorchid\Models\KlorchidBooleanStatusModel;
use Orchid\Filters\Filterable;
use Orchid\Screen\AsSource;

class Country extends KlorchidBooleanStatusModel
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
    protected $table = 'countries';

    protected $primaryKey = 'id';

    protected $attributes = [
        'status' => True
    ];

    protected $fillable = [
        'name',
        'alpha2',
    ];

    protected $allowedFilters = [
        'name',
        'alpha2',
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
        'alpha2',
        'updated_at',
        'updated_by',
        'created_at',
        'created_by',
        'status'

    ];

    protected $appends = [
        'statusName'
    ];




}
