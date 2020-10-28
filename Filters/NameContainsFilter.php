<?php

namespace Kamansoft\Klorchid\Filters;

use Illuminate\Database\Eloquent\Builder;
use Orchid\Filters\Filter;
use Orchid\Screen\Field;
use Orchid\Screen\Fields\Input;

class NameContainsFilter extends Filter{
    use FieldContainsFilterTrait;
    /**
     * parameters
     *
     * @var array
     */
    public $parameters = ['name'];

    /**
     * name
     *
     * @return string
     */
    public function name():string {
        return __(':field Contains',[
            "field"=>__('Name')
        ]);
    }


}
