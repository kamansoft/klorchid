<?php


namespace Kamansoft\Klorchid\Layouts\Traits;


trait MultiModeScreenLayoutTrait
{



    private string $repository_mode_keyname = "screen_mode";

    public function multiModeScreenQueryRequiredKeys(): array
    {
        return [
            $this->getScreenQueryModeKeyname()
        ];
    }

    /**
     * @return string
     */
    public function getScreenQueryModeKeyname(): string
    {
        return $this->repository_mode_keyname;
    }

    public function getScreenMode(): string
    {
        return $this->query->get($this->getScreenQueryModeKeyname());
    }


}
