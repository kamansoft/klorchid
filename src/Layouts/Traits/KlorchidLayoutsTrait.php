<?php


trait KlorchidLayoutsTrait
{


    public function getModel()
    {

        return $this->query->get(data_keyname_prefix()) ;
    }



    public function prefixFormDataKeyTo(?string $attribute_name = null)
    {
        return data_keyname_prefix($attribute_name);
    }



}