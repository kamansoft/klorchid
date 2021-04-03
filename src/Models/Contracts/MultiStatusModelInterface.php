<?php


namespace Kamansoft\Klorchid\Models\Contracts;


interface MultiStatusModelInterface
{

    /**
     * Allow the klorchid system to determinate the disabled (bloked invalid non usable) status of a model.
     *
     * @return mixed the disabled Status value
     */
    static function disabledStatusValue();

    /**
     *
     * Should should return a keyname value paired array with all the posible values for a model, example:
     *
     * [
     *      "ivalid"=>"0",
     *      "ivalid"=>"1",
     * ]
     *
     * @return array
     */
    static function statusValues(): array;

    static function statusToString($status): string;

    public function statusSet($status, string $reason): self;

    public function getStringStatusAttribute(): string;

    public function getDisabledStatusValue();

    /**
     * tells the constructor which is the status that indicates
     * that the model is disabled from the statusStringValues array
     * @return mixed
     */


}