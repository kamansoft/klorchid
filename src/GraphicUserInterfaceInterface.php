<?php


namespace Kamansoft\Klorchid;

use Illuminate\Support\Collection;

interface GraphicUserInterfaceInterface
{

    public function getPermission():Collection;
    public function getAllowAllPermission():Collection;
}