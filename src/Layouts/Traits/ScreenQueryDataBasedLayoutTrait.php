<?php

namespace Kamansoft\Klorchid\Layouts\Traits;



trait ScreenQueryDataBasedLayoutTrait
{
    private string $screen_query_layout_data_keyname = 'layout_data';


    public function dataAttribute(string $attributeName)
    {
        return implodeWithDot($this->getScreenQueryLayoutDataKeyname(),$attributeName);
    }

    public function getData(){
        return $this->query->get($this->getScreenQueryLayoutDataKeyname());
    }

    public function getScreenQueryLayoutDataKeyname()
    {
        return $this->screen_query_layout_data_keyname;
    }
    public function multiStatusScreenQueryRequiredKeys(): array
    {
        return [
            $this->getScreenQueryLayoutDataKeyname()
        ];
    }
}
