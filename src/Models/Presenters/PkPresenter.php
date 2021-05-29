<?php


namespace Kamansoft\Klorchid\Models\Presenters;


use Illuminate\Database\Eloquent\Model;
use Orchid\Screen\Actions\Link;

/**
 * Class PkPresenter
 *
 * @property \Illuminate\Database\Eloquent\Model $entity
 *
 * @package Kamansoft\Klorchid\Models\Presenters
 */
class PkPresenter extends \Orchid\Support\Presenter
{
    public function short(): string
    {
        /*
        $this->entity->getKey()
        $uuid_segments =explode('-',$this->entity->getKey());
        return end($uuid_segments);
        */

        return substr($this->entity->getKey(), -12);
    }


    public function link(?string $display_text = null)
    {
        $display_text = $display_text ?: $this->short();
        return Link::make($display_text);
    }


}