<?php

namespace Kamansoft\Klorchid\Notificator;

use Orchid\Alert\Alert;


interface NotificaterInterface
{


    public function info(string $message):Alert;

    public function success(string $message):Alert;

    public function error(string $message):Alert;

    public function warning(string $message):Alert;



}