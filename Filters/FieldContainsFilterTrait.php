<?php
namespace Kamansoft\Klorchid\Filters;

use Illuminate\Database\Eloquent\Builder;
use Orchid\Filters\Filter;
use Orchid\Screen\Field;
use Orchid\Screen\Fields\Input;


trait FieldContainsFilterTrait {



    /**
     * run
     *
     * @param  Builder $builder
     * @return Builder
     */
    public function run(Builder $builder):Builder
    {
        return $builder->where(
            $this->parameters[0],
            'like',
            '%'.$this->request->get($this->parameters[0]).'%'
        );
    }

    /**
     * @return Field[]
     */
    public function display():array{
        return [
            Input::make('name')
                ->title($this->name())
        ];
    }

}
