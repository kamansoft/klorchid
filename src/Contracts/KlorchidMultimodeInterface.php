<?php


namespace Kamansoft\Klorchid\Contracts;

use Illuminate\Support\Collection;
interface KlorchidMultimodeInterface
{

    /**
     * @return string
     */
    public function getMode();

    /**
     * @param string $mode
     * @return KlorchidMultiModeTrait
     */
    public function setMode(?string $mode = null);

    public function isValidMode($mode);

    public function getModeMethod($mode);

    public function setAvailableModes(?Collection $modes);

    public function getAvailableModes();

    public function getModesByMethodsName(string $needle = 'Mode'): Collection;
}