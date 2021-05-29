<?php


namespace Kamansoft\Klorchid\Layouts;


use Kamansoft\Klorchid\Contracts\KlorchidScreenQueryRepositoryDependentInterface;
use Kamansoft\Klorchid\Layouts\Contracts\KlorchidCollectionDependantLayoutInterface;
use Kamansoft\Klorchid\Layouts\Traits\KlorchidCollectionDependantLayoutTrait;
use Kamansoft\Klorchid\Layouts\Traits\KlorchidScreenQueryRepositoryDependantLayoutTrait;

abstract class KlorchidListLayout extends \Orchid\Screen\Layouts\Table implements KlorchidScreenQueryRepositoryDependentInterface, KlorchidCollectionDependantLayoutInterface
{

    use KlorchidCollectionDependantLayoutTrait;

    private static string $screen_query_edit_route_keyname = 'edit_route_name';

    /**
     * @return string
     */
    public static function getScreenQueryEditRouteKeyname(): string
    {
        return self::$screen_query_edit_route_keyname;
    }

    public $target = '';


    public function __construct()
    {
        $this->target = self::getScreenQueryCollectionKeyname();

    }

    /**
     * @inheritDoc
     */
    protected function columns(): array
    {
        return $this->listColumns();
    }


    abstract public function listColumns(): array;

    /*
    public function klorchidListLayoutScreenQueryRequiredKeys(): array
    {
        return ['edit_route_name'];
    }*/
}