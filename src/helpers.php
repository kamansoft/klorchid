<?php

declare(strict_types=1);


if (!function_exists('implodeWithDot')) {
    function implodeWithDot(...$pieces)
    {

        return implode('.', $pieces);
    }
}

if (!function_exists('getObjectMethodsThatEndsWith')) {
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
    function getObjectMethodsThatEndsWith($object, $needle, int $accessor = \ReflectionMethod::IS_PUBLIC): \Illuminate\Support\Collection
    {

        $reflection = new \ReflectionClass($object);
        return collect($reflection->getMethods($accessor))->mapWithKeys(function ($method) use ($needle) {
            return [\Illuminate\Support\Str::snake(strstr($method->name, $needle, true)) => $method->name];
        })->reject(function ($pair) use ($needle) {
            $method_prefix = strstr($pair, $needle, true);
            return !$method_prefix or
                str_contains($method_prefix, 'set') or
                str_contains($method_prefix, 'get') or
                str_contains($method_prefix, 'init');
        });

    }
}

if (!function_exists('getObjectMethodsThatStartsWith')) {
    /**
     *
     * Maps through the $object's reflection class Object, and returns all the methods
     * which name's starts with the value at $needle .
     * and returns a collection with all of those methods with keys names
     *
     * @param $object
     * @param $needle
     * @param int $accessor
     * @return \Illuminate\Support\Collection
     * @throws ReflectionException
     */
    function getObjectMethodsThatStartsWith($object, $needle, int $accessor = \ReflectionMethod::IS_PUBLIC): \Illuminate\Support\Collection
    {

        $reflection = new \ReflectionClass($object);
        return collect($reflection->getMethods($accessor))->mapWithKeys(function ($method) use ($needle) {
            $mode_name = empty(explode($needle, $method->name)[1]) ?: \Illuminate\Support\Str::snake(explode($needle, $method->name)[1]);
            return [$mode_name => $method->name];
        })->reject(function ($method_name) use ($needle) {
            return !str_starts_with($method_name, $needle);
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
            return [\Illuminate\Support\Str::snake(strstr($method->name, $needle, true)) => $method->name];
        })->reject(function ($pair) use ($needle) {
            return !strstr($pair, $needle, true);//or
            //strstr($pair, $needle, true) === 'set' or
            //strstr($pair, $needle, true) === 'get';
        });
    }
}


if (!function_exists('param_name_for_model')) {

    /**
     * Get the recomended name for a route param name related to a model
     *
     * @param string $model_class
     * @return void
     */
    function param_name_for_model(string $model_class)
    {
        $exploded_class = explode('\\',$model_class);
        return \Illuminate\Support\Str::snake(end($exploded_class));
    }
}

if (!function_exists('forwardToBack')) {
    /**
     *
     * Convert foward slash to backslash from a string
     *
     * @param $path string
     * @return string
     */
    function forwardToBack($path)
    {
        return str_replace('/', '\\', $path);
    }
}

if (!function_exists('backToForward')) {
    /**
     *
     * Convert foward slash to backslash from a string
     *
     * @param $path string
     * @return string
     */
    function backToForward($path)
    {
        return str_replace('\\', '/', $path);
    }
}
