<?php


namespace Kamansoft\Klorchid\Models\Contracts;


interface IntegerStatusModelInterface
{
    static function getStatusName(int $status): string;
}