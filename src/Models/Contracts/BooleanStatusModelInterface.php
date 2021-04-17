<?php


namespace Kamansoft\Klorchid\Models\Contracts;


interface BooleanStatusModelInterface
{
    static function getStatusName(bool $status): string;
}