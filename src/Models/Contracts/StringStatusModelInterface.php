<?php


namespace Kamansoft\Klorchid\Models\Contracts;


interface StringStatusModelInterface
{
    static function getStatusName(string $status): string;
}