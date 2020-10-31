<?php


namespace Kamansoft\Klorchid\Layouts;


use Orchid\Screen\Layouts\Table;
use Kamansoft\Klorchid\Layouts\LayoutTrait;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\TD;

abstract class ListLayout extends Table
{
    use LayoutTrait;



    abstract protected function kcolumns(): array;

    protected function columns(): array
    {
        $extra_columns = [

            TD::set('created_at', __('Created at'))->filter(TD::FILTER_DATE)->sort(),
            TD::set('creatorName', __('Created by'))->filter(TD::FILTER_TEXT)->sort(),
            TD::set('updated_at', __('Updated at'))->filter(TD::FILTER_DATE)->sort(),
            TD::set('updaterName', __('Updated by'))->filter(TD::FILTER_TEXT)->sort()
        ];

        $element_columns = $this->kcolumns();
        array_push($element_columns, ...$extra_columns);
        return $element_columns;
    }
}
