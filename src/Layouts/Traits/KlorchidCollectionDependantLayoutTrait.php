<?php

namespace Kamansoft\Klorchid\Layouts\Traits;


use Kamansoft\Klorchid\Models\Contracts\KlorchidModelsInterface;
use Kamansoft\Klorchid\Models\KlorchidEloquentModel;
use Kamansoft\Klorchid\Models\KlorchidMultiStatusModel;

trait KlorchidCollectionDependantLayoutTrait
{
    use KlorchidScreenQueryRepositoryDependantLayoutTrait;

    private static string $screen_query_collection_keyname = 'collection';


    public function getCollection()
    {
        return $this->query->get(self::getScreenQueryCollectionKeyname());
    }

    public static function getScreenQueryCollectionKeyname(): string
    {
        return self::$screen_query_collection_keyname;
    }

    public function collectionDependantScreenQueryRequiredKeys(): array
    {
        return [
            self::getScreenQueryCollectionKeyname()
        ];
    }
}
