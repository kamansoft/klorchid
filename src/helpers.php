<?php

declare(strict_types=1);

if (!function_exists('data_keyname_prefix')) {
    function data_keyname_prefix(?string $attribute_name = null)
    {

        $keyname = config('klorchid.screen_query_required_elements.element_to_display');

        if (is_null($keyname)){
            return $attribute_name;
        }

        if (is_null($attribute_name)) {
            return $keyname;
        } else {

            return config('klorchid.screen_query_required_elements.element_to_display') . '.' . $attribute_name;
        }
    }
}
