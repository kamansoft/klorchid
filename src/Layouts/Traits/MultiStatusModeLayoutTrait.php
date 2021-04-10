<?php


namespace Kamansoft\Klorchid\Layouts\Traits;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

trait MultiStatusModeLayoutTrait
{

    use ScreenQueryValidationForLayoutTrait;
    use ScreenQueryDataBasedLayoutTrait;

    private Collection $status_class_kernels;




    public function getStatus()
    {
        return $this->query->get($this->getScreenQueryLayoutDataKeyname())->status;
    }

    public function setStatusClassKernels(): Collection
    {

        return $this->status_class_kernels = collect($this->statusClassKernels());
    }

    public function getClassForStatus(string $status_keyname): string
    {
        return "";
    }
}
