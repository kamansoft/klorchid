<?php

namespace Kamansoft\Klorchid\Models\Traits;

trait KlorchidModelsExtraAppendTrait
{
    static string $extra_appends_attributes_name_suffix = 'extra_appends';

    /**
     * merge the current value of the self appends attribute  with all the ones that ends with
     * $extra_appends_attributes_name_suffix
     *
     * @return $this
     * @throws \ReflectionException
     */
    public function setExtraAppends():self
    {
        getObjectPropertiesWith($this, self::$extra_appends_attributes_name_suffix, \ReflectionMethod::IS_PROTECTED)
            ->map(function ($extra_appends) {

                if (!is_array($this->$extra_appends)) {
                    throw new \Error(self::class . 'class attribute: ' . $extra_appends . ' must be an array');
                }

                $this->setAppends( array_merge($this->appends, $this->$extra_appends));
            });

        return $this;
    }
}