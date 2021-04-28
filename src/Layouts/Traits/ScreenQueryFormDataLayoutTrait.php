<?php

namespace Kamansoft\Klorchid\Layouts\Traits;



trait ScreenQueryFormDataLayoutTrait
{
    private string $screen_query_form_data_keyname = 'form_data';


    public function dataAttribute(string $attributeName)
    {
        return implodeWithDot($this->getScreenFormDataKeyname(),$attributeName);
    }

    public function getData(){
        return $this->query->get($this->getScreenFormDataKeyname());
    }

    public function getScreenFormDataKeyname(): string
    {
        return $this->screen_query_form_data_keyname;
    }
    public function formDataScreenQueryRequiredKeys(): array
    {
        return [
            $this->getScreenFormDataKeyname()
        ];
    }
}
