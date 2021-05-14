<?php

namespace Kamansoft\Klorchid\Layouts\Traits;


use Kamansoft\Klorchid\Models\Contracts\KlorchidModelsInterface;
use Kamansoft\Klorchid\Models\KlorchidEloquentModel;
use Kamansoft\Klorchid\Models\KlorchidMultiStatusModel;

trait KlorchidModelDependantLayoutTrait
{
    use KlorchidScreenQueryRepositoryDependantLayoutTrait;
    private static string $screen_query_model_keyname = 'model';


    public function getModel()
    {
        $this->query->get(self::getScreenQueryModelKeyname());
        return $this->query->get(self::getScreenQueryModelKeyname());
    }

  public static function getScreenQueryModelKeyname(): string
    {
        return self::$screen_query_model_keyname;
    }

    public function modelDependantScreenQueryRequiredKeys(): array
    {
        return [
            self::getScreenQueryModelKeyname()
        ];
    }
}
