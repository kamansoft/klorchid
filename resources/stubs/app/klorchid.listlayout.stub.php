<?php


namespace DummyNamespace;


use DummyFullScreenClass;
use Kamansoft\Klorchid\Models\Contracts\PkPresentableInterface;
use Kamansoft\Klorchid\Models\Contracts\BlamingPrensentableInterface;
use Orchid\Screen\TD;

class DummyClass extends \Kamansoft\Klorchid\Layouts\KlorchidListLayout
{

    public function listColumns(): array
    {
        return [
            TD::make('id', __('Id'))->sort() ->width(100)->render(function (PkPresentableInterface $model) {return $model->pkPresenter()->link($this->query->get($this->getScreenQueryRouteNamesKeyname())[DummyScreenClass::EDIT_MODE]);}),

            //Add entity fields here

            //klorchid common fields
            TD::make('statusName', __('Status')),
            //TD::make('created_by', __('Created by'))->alignRight()->render(function (BlamingPrensentableInterface $model) {return $model->blamingPresenter()->creatorLink();}),
            //TD::make('created_at', __('Creation date'))->alignLeft()->width(269)->filter(TD::FILTER_DATE),
            //TD::make('updated_by', __('Updated by'))->alignRight()->render(function (BlamingPrensentableInterface $model) {return $model->blamingPresenter()->updaterLink();}),
            //TD::make('updated_at', __('Update date'))->alignLeft()->width(269)->filter(TD::FILTER_DATE),


        ];
    }
}