<?php


namespace Kamansoft\Klorchid\Layouts\Traits;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Kamansoft\Klorchid\Models\Contracts\KlorchidMultiStatusModelInterface;

/**
 * Trait MultiStatusModelLayoutTrait
 * @package Kamansoft\Klorchid\Layouts\Traits
 * @method \Kamansoft\Klorchid\Models\KlorchidMultiStatusModel getModel()
 */
trait MultiStatusModelLayoutTrait
{

    use KlorchidModelDependantLayoutTrait;
    use KlorchidScreenQueryRepositoryDependantLayoutTrait;




    public function getStatusFieldClass():string{
        return 'form-control text-' . $this->getModel()->getStatusColorClass();
    }

    public function getStatus()
    {
        return $this->getModel()->status;
    }


}
