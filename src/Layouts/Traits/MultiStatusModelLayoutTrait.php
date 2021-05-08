<?php


namespace Kamansoft\Klorchid\Layouts\Traits;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Kamansoft\Klorchid\Models\Contracts\KlorchidMultiStatusModelInterface;

/**
 * Trait MultiStatusModelLayoutTrait
 * @package Kamansoft\Klorchid\Layouts\Traits
 * @method KlorchidMultiStatusModelInterface getModel()
 */
trait MultiStatusModelLayoutTrait
{

    use KlorchidModelDependantLayoutTrait;
    use KlorchidScreenQueryRepositoryDependantLayoutTrait;




    public function getStatus()
    {
        $this->getModel()->status;
        //return $this->query->get($this->getScreenQueryModelKeyname())->status;
    }


}
