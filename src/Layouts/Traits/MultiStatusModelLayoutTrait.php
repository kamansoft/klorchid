<?php


namespace Kamansoft\Klorchid\Layouts\Traits;


use Illuminate\Support\Collection;

trait MultiStatusModelLayoutTrait
{

    use ScreenQueryValidationForLayoutTrait;

    private Collection $status_class_kernels;

    public function multiStatusScreenQueryRequiredKeys(): array
    {
        return [
            'data'
        ];
    }

    public function setStatusClassKernels(): Collection
    {
        $this->status_class_kernels = collect($this->statusClassKernels());
    }

    public function getClassForStatus(string $status_keyname): string
    {
        return "";
    }


}