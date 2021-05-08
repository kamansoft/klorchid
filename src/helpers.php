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
     * Maps through the $object's reflection class Object, and returns all the methods
     * which name's ends with the value at $needle .
     * and returns a collection with all of those methods with keys names
     *
     * @param $object
     * @param $needle
     * @param int $accessor
     * @return \Illuminate\Support\Collection
     * @throws ReflectionException
     */
    function getObjectMethodsWith($object, $needle, int $accessor = \ReflectionMethod::IS_PUBLIC): \Illuminate\Support\Collection
    {

        $reflection = new \ReflectionClass($object);
        return collect($reflection->getMethods($accessor))->mapWithKeys(function ($method) use ($needle) {
            return [Str::snake(strstr($method->name, $needle, true)) => $method->name];
        })->reject(function ($pair) use ($needle) {
            $method_prefix = strstr($pair, $needle, true);
            return !$method_prefix or
                str_contains($method_prefix, 'set') or
                str_contains($method_prefix, 'get') or
                str_contains($method_prefix, 'init');
        });

    }
}


if (!function_exists('getObjectPropertiesWith')) {
    /**
     *
     * Maps through the $object's reflection class Object, and returns all the attributes or
     * properties which name's ends with the value at $needle .
     * and returns a collection with all of those attributes with keys names
     *
     * @param $object
     * @param $needle
     * @param int $accessor
     * @return \Illuminate\Support\Collection
     * @throws ReflectionException
     */
    function getObjectPropertiesWith($object, $needle, $accessor = \ReflectionMethod::IS_PUBLIC)
    {

        $reflection = new \ReflectionClass($object);
        return collect($reflection->getProperties($accessor))->mapWithKeys(function ($method) use ($needle) {
            return [Str::snake(strstr($method->name, $needle, true)) => $method->name];
        })->reject(function ($pair) use ($needle) {
            return !strstr($pair, $needle, true);//or
            //strstr($pair, $needle, true) === 'set' or
            //strstr($pair, $needle, true) === 'get';
        });
    }
}
