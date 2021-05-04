<?php

namespace Kamansoft\Klorchid\Layouts\Traits;



use Kamansoft\Klorchid\Models\Contracts\KlorchidModelsInterface;
use Kamansoft\Klorchid\Models\KlorchidMultiStatusModel;

trait ScreenQueryFormDataLayoutTrait
{
    public static string $screen_query_form_data_keyname = 'form_data';

    static function fullFormInputName(string $attributeName): string
    {
        return implodeWithDot(self::$screen_query_form_data_keyname,$attributeName);
    }

    public function getData():KlorchidMultiStatusModel{
        return $this->query->get($this->getScreenFormDataKeyname());
    }

    public function getScreenFormDataKeyname(): string
    {
        return self::$screen_query_form_data_keyname;
    }
    public function formDataScreenQueryRequiredKeys(): array
    {
        return [
            $this->getScreenFormDataKeyname()
        ];
    }
}
