<?php


namespace Kamansoft\Klorchid\Models\Traits;


use Kamansoft\Klorchid\Models\KlorchidUser;
use Kamansoft\Klorchid\Models\Presenters\PkPresenter;


trait KlorchidModelsExtraCastTrait
{

    static string $extra_casts_attributes_name_sufix = 'extra_casts';

    /**
     * Maps for all protected properties that ends with extra_casts at its name,
     *
     * @return $this
     * @throws \ReflectionException
     */
    public function setCasts(): self
    {
        getObjectPropertiesWith($this, self::$extra_casts_attribdutes_name_sufix, \ReflectionMethod::IS_PROTECTED)
            ->map(function ($extra_class) {

                if (!is_array($this->$extra_class)) {
                    throw new \Error(self::class . 'class attribute: ' . $extra_class . ' must be an array');
                }

                $this->casts = array_merge($this->casts, $this->$extra_class);
            });

        return $this;
    }



}