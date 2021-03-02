<?php

namespace Kamansoft\Klorchid\Layouts\Traits;

trait KlorchidMultimodeScreenLayoutsTrait
{


    public function getScreenMode()
    {

        $query_key_name = config('klorchid.screen_query_required_elements.screen_mode_layout');

        return $query_key_name ? $this->query->get($query_key_name) : null;

    }

    public function getScreenModePerm(string $mode)
    {

        $query_key_name = config('klorchid.screen_query_required_elements.screen_mode_perms');

        return $query_key_name ? $this->query->get($query_key_name)->get($mode) : null;

    }


}