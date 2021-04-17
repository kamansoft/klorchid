<?php


namespace Kamansoft\Klorchid\Models\Traits;


use Kamansoft\Klorchid\Models\KlorchidUserModel;


trait KlorchidEloquentModelsTrait
{


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


    /**
     * Maps for all protected properties that ends with extra_casts at its name,
     *
     * @return $this
     * @throws \ReflectionException
     */
    public function setCasts()
    {
        getObjectPropertiesWith($this, 'extra_casts', \ReflectionMethod::IS_PROTECTED)
            ->map(function ($extra_class) {

                if (!is_array($this->$extra_class)) {
                    throw new \Error(self::class . 'class attribute: ' . $extra_class . ' must be an array');
                }


                $this->casts = array_merge($this->casts, $this->$extra_class);
            });

        return $this;
    }


    static public function userModelClass(): string
    {
        return KlorchidUserModel::class;
    }

    public function creator()
    {

        return $this->belongsTo(self::userModelClass(), config('klorchid.models_common_field_names.creator'), 'id');
    }

    public function updater()
    {
        return $this->belongsTo(self::userModelClass(),config('klorchid.models_common_field_names.last_updater'), 'id');
    }

}