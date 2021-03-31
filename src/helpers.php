<?php

declare(strict_types=1);

if (!function_exists('model_keyname')) {
    function model_keyname(?string $attribute_name = null)
    {

        $keyname = config('klorchid.screen_query_required_elements.element_to_display');

        if (is_null($keyname)) {
            return $attribute_name;
        }

        if (is_null($attribute_name)) {
            return $keyname;
        } else {

            return config('klorchid.screen_query_required_elements.element_to_display') . '.' . $attribute_name;
        }
    }
}

if (!function_exists('collection_keyname')) {
    function collection_keyname(?string $attribute_name = null)
    {
        return \Illuminate\Support\Str::plural(model_keyname($attribute_name));

    }
}

if (!function_exists('glueWithDot')) {
    function implodeWithDot(...$pieces){

       return implode('.',$pieces);
    }
}
