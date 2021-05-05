<?php


namespace Kamansoft\Klorchid\Layouts\Traits;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

trait MultiStatusModelLayoutTrait
{

    use ScreenQueryFormDataLayoutTrait;
    use ScreenQueryValidationForLayoutsTrait;
    public function getStatus()
    {
        return $this->query->get($this->getScreenFormDataKeyname())->status;
    }


}
