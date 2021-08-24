<?php

namespace Kamansoft\Klorchid\Layouts\Traits;


trait KlorchidModelDependantLayoutTrait
{
    use KlorchidScreenQueryRepositoryDependantLayoutTrait;

    private static string $screen_query_model_keyname = 'model';


    public function getModel()
    {
        return $this->query->get(self::getScreenQueryModelKeyname());
    }

    public static function getScreenQueryModelKeyname(): string
    {
        return self::$screen_query_model_keyname;
    }

    public static function setScreenQueryModelKeyname($value)
    {
        self::$screen_query_model_keyname = $value;
    }

    public function modelDependantScreenQueryRequiredKeys(): array
    {
        return [
            self::getScreenQueryModelKeyname()
        ];
    }
}
