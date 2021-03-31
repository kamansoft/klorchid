<?php


namespace Kamansoft\Klorchid\Layouts\Traits;


trait KlorchidMultimodeLayoutsTrait
{
    public $repository_mode_keyname = 'mode';

    public function getScreenMode():string{
        return $this->query->get($this->getRepositoryModeKeyName());
    }

    public function getRepositoryModeKeyName():string{
        return $this->repository_mode_keyname;
    }
}