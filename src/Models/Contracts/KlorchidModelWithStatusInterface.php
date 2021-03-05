<?php


namespace Kamansoft\Klorchid\Models\Contracts;


interface KlorchidModelWithStatusInterface
{

    public function getStringStatusAttribute(): string;

    static public function statusStringValues(): array;

    static public function statusToString($status): string;

    public function statusToggle(string $reason):self;
}