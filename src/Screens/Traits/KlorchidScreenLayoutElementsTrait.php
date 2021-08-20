<?php


namespace Kamansoft\Klorchid\Screens\Traits;


use Illuminate\Support\Collection;
use Kamansoft\Klorchid\Screens\Contracts\KlorchidScreenLayoutElementsInterface;


/**
 * Trait KlorchidScreenLayoutElementsTrait
 * @method KlorchidScreenLayoutElementsInterface layoutElements()
 * @package Kamansoft\Klorchid\Screens\Traits
 *
 */
trait KlorchidScreenLayoutElementsTrait
{


    private Collection $layout_elements;

    public function layout(): array
    {
        return $this->getLayoutElements()->toArray();
    }

    /**
     * Retrives the value of $layout_elements if is not set wit will initialized $layout_elements and return it
     * @return Collection
     */
    public function getLayoutElements(): Collection
    {
        return $this->initLayoutElements()->layout_elements;
    }

    /**
     * set $layout_elements with a collection from $elements array
     * @param array $elements
     * @return KlorchidScreenLayoutElementsTrait
     */
    public function setLayoutElements(array $elements): self
    {
        $this->layout_elements = collect($elements);
        return $this;
    }

    /**
     * Initialize the $layout_elements collection with the value at $elements params or with the array values
     * from layoutElements() screen method.
     * @param array|null $elements if null screen's layoutElements() methods will be used
     * @return $this
     */
    public function initLayoutElements(?array $elements = null): self
    {
        if (!isset($this->layout_elements)) {
            $this->setLayoutElements(is_null($elements) ? $this->layoutElements() : $elements);
        }
        return $this;
    }
}