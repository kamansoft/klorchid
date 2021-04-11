<?php

declare(strict_types=1);


if (!function_exists('implodeWithDot')) {
    function implodeWithDot(...$pieces)
    {

        return implode('.', $pieces);
    }
}

if (!function_exists('getObjectMethodsWith')) {
    /**
     *
     * Maps through the reflectionClass object from the $object, and returns all the methods
     * which name's ends with the value at $needle .
     * and returns a collection with all of those methods with keys names
     *
     * @param $object
     * @param $needle
     * @return \Illuminate\Support\Collection
     * @throws ReflectionException
     */
    function getObjectMethodsWith($object, $needle)
    {

        $reflection = new \ReflectionClass($object);
        return collect($reflection->getMethods(\ReflectionMethod::IS_PUBLIC))->mapWithKeys(function ($method) use ($needle) {
            return [Str::snake(strstr($method->name, $needle, true)) => $method->name];
        })->reject(function ($pair) use ($needle) {
            return !strstr($pair, $needle, true) or
                strstr($pair, $needle, true) === 'set' or
                strstr($pair, $needle, true) === 'get';
        });
    }
}

