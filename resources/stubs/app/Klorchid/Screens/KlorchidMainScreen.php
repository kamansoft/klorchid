<?php

namespace App\Klorchid\Screens;

use Orchid\Screen\Screen;

class KlorchidMainScreen extends Screen
{
    /**
     * Display header name.
     *
     * @var string
     */
    public $name = 'Main Klorchid Screen' ;

    /**
     * Display header description.
     *
     * @var string|null
     */
    public $description = 'The main Screen for all klorchid based app';

    /**
     * Query data.
     *
     * @return array
     */
    public function query(): array
    {
        return [];
    }

    /**
     * Button commands.
     *
     * @return \Orchid\Screen\Action[]
     */
    public function commandBar(): array
    {

        return [];
    }

    /**
     * Views.
     *
     * @return \Orchid\Screen\Layout[]|string[]
     */
    public function layout(): array
    {
        return [];
    }
}
