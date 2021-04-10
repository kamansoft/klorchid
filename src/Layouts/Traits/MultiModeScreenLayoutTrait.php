<?php


namespace Kamansoft\Klorchid\Layouts\Traits;


trait MultiModeScreenLayoutTrait
{

    use ScreenQueryValidationForLayoutTrait;

    private string $repository_mode_keyname = "screen_mode";

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
