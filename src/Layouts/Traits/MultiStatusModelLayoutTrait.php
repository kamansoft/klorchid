<?php


namespace Kamansoft\Klorchid\Layouts\Traits;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

trait MultiStatusModelLayoutTrait
{


    public function getStatus()
    {
        return $this->query->get($this->getScreenQueryDataKeyname())->status;
    }


}
