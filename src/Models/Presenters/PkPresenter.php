<?php


namespace Kamansoft\Klorchid\Models\Presenters;


use Illuminate\Database\Eloquent\Model;
use Orchid\Icons\Icon;
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
    /**
     * short value representation of an element uuid
     * @return string
     */
    public function short(): string
    {
        /*
        $this->entity->getKey()
        $uuid_segments =explode('-',$this->entity->getKey());
        return end($uuid_segments);
        */

        return substr($this->entity->getKey(), -12);
    }

    public function shortPkWithIcon(string $orchid_icon='doc'){
        return "<x-orchid-icon path=\"$orchid_icon\"/>".substr($this->entity->getKey(), -12);
    }

    /**
     *  Returns a formated commom link for klorchid
     *
     * @param string $url_name
     * @param string|null $display_text
     * @return Link
     */
    public function link(string $url_name, ?string $display_text = null): Link
    {
        $display_text = $display_text ?: $this->short();


        $text_class="btn btn-link ";



        if ($this->entity->isLockedByStatus()){
            $text_class.="text-".$this->entity->getStatusColorClass();
        }

        return Link::make($display_text)->class($text_class)->route(
            $url_name,
            $this->entity->getKey()
        );
    }


}