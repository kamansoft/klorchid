<?php


namespace Kamansoft\Klorchid\Layouts;


use Illuminate\Support\Facades\Log;
use Kamansoft\Klorchid\Contracts\KlorchidScreenQueryRepositoryDependentInterface;
use Kamansoft\Klorchid\Layouts\Contracts\KlorchidCollectionDependantLayoutInterface;
use Kamansoft\Klorchid\Layouts\Traits\KlorchidCollectionDependantLayoutTrait;
use Kamansoft\Klorchid\Layouts\Traits\KlorchidRouteNamesDependantLayoutTrait;
use Orchid\Screen\Layouts\Table;
use Orchid\Support\Facades\Dashboard;


abstract class KlorchidListLayout extends Table implements KlorchidScreenQueryRepositoryDependentInterface, KlorchidCollectionDependantLayoutInterface
{

    use KlorchidRouteNamesDependantLayoutTrait;
    use KlorchidCollectionDependantLayoutTrait;

    // private static string $screen_query_edit_route_keyname = 'edit_route_name';

    public $target;

    public function __construct()
    {
        if (empty($this->target)) {
            $this->target = self::getScreenQueryCollectionKeyname();
        } else {
            Log::info( static::class . " Standart orchid \"target\" will be used with the value " . $this->target . " instead of klorchid common value for list layout: " . self::getScreenQueryCollectionKeyname()." at screen: ".get_class(Dashboard::getCurrentScreen()));
            self::setScreenQueryCollectionKeyname($this->target);
        }

    }

    /**
     * @return string
     */
    public static function getScreenQueryEditRouteKeyname(): string
    {
        return self::$screen_query_edit_route_keyname;
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