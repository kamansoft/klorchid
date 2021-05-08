<?php

namespace Kamansoft\Klorchid\Layouts\Traits;


use Kamansoft\Klorchid\Models\Contracts\KlorchidModelsInterface;
use Kamansoft\Klorchid\Models\KlorchidEloquentModel;
use Kamansoft\Klorchid\Models\KlorchidMultiStatusModel;

trait KlorchidModelDependantLayoutTrait
{
    use KlorchidScreenQueryRepositoryDependantLayoutTrait;
    protected static string $screen_query_model_keyname = 'model';


    public function getModel()
    {
        return $this->query->get($this->getScreenQueryModelKeyname());
    }

    public function getScreenQueryModelKeyname(): string
    {
        return self::$screen_query_model_keyname;
    }

    public function modelDependantScreenQueryRequiredKeys(): array
    {
        return [
            $this->getScreenQueryModelKeyname()
        ];
    }
}
