<?php


namespace Kamansoft\Klorchid\Layouts\Traits;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

trait MultiStatusModelLayoutTrait
{

    use ScreenQueryDataBasedLayoutTrait;
    use ScreenQueryValidationForLayoutTrait;
    public function getStatus()
    {
        return $this->query->get($this->getScreenQueryDataKeyname())->status;
    }


}
