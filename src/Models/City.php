<?php

namespace Kamansoft\Klorchid\Models;


use Datakrama\Eloquid\Traits\Uuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Kamansoft\Klorchid\Models\KlorchidBooleanStatusModel;
use Orchid\Filters\Filterable;
use Orchid\Screen\AsSource;

class City extends KlorchidBooleanStatusModel
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
    protected $table = 'cities';

    protected $primaryKey = 'id';

    protected $attributes = [
        'status' => True
    ];

    protected $fillable = [
        'name',
        'state_id'

    ];

    protected $allowedFilters = [
        'name',
        'state_id',
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
        'state_id',
        'updated_at',
        'updated_by',
        'created_at',
        'created_by',
        'status'

    ];

    protected $appends = [
        'statusName'
    ];

    public function state(){
        return $this->belongsTo(State::class);
    }


}
