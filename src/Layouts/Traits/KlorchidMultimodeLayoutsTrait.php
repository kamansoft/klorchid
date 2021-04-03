<?php


namespace Kamansoft\Klorchid\Layouts\Traits;


trait KlorchidMultimodeLayoutsTrait
{
    private string $repository_mode_keyname = "mode";

    public function multimodeScreenQueryRequiredKeys(): array
    {
        return [
            $this->getRepositoryModeKeyname()
        ];
    }

    /**
     * @return string
     */
    public function getRepositoryModeKeyname(): string
    {
        return $this->repository_mode_keyname;
    }

    public function getScreenMode(): string
    {
        return $this->query->get($this->getRepositoryModeKeyName());
    }


}