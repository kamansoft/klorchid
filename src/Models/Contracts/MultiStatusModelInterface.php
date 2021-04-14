<?php


namespace Kamansoft\Klorchid\Models\Contracts;


use Illuminate\Support\Collection;

interface MultiStatusModelInterface
{


    /*
        static function statusColors():array;

        static function getStatusColors():Collection;

        public function getStatusColor($param);*/


    /**
     *
     * Should should return a keyname value paired array with all the posible status values for a model, example:
     *
     * [
     *      "invalid"=>"0",
     *      "valid"=>"1",
     * ]
     *
     * @return array
     */
    static function statusValues(): array;

    /**
     *
     * A subset of statusValues method returned array (only values) ,
     * To be used by klorchid system in the moment to determinate if the model
     * is able to be edited according its current status
     *
     * @return array the status values to be taken as disabled or locked statues
     */
    static function lockedStatus(): array;

    public function isLockedByStatus(?string $status = null ):bool;

    static function statusToString($status): string;

    public function statusSet($status, string $reason): self;

    public function getStatusNameAttribute(): string;





}
