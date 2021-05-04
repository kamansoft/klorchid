<?php


namespace Kamansoft\Klorchid\Screens\Contracts;


use phpDocumentor\Reflection\Types\Collection;

interface KlorchidScreenLayoutElementsInterface
{


    /**
     * Initialize the $layout_elements collection with the value at $elements params or with the array values
     * from layoutElements() screen method.
     * @param array|null $elements if null screen's layoutElements() methods will be used
     * @return $this
     */
    public function initLayoutElements(?array $elements = null): self;

    /**
     * set $layout_elements with a collection from $elements array
     * @param array $elements
     * @return \Kamansoft\Klorchid\Screens\Traits\KlorchidScreenLayoutElementsTrait
     */
    public function setLayoutElements(array $elements): self;

    /**
     * Retrives the value of $layout_elements if is not set wit will initialized $layout_elements and return it
     * @return \Illuminate\Support\Collection
     */
    public function getLayoutElements(): Collection;

}