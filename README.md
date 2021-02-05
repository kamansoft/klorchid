[![time tracker](https://wakatime.com/badge/github/kamansoft/klorchid.svg)](https://wakatime.com/badge/github/kamansoft/klorchid)

# Klorchid

A group of classes to ease the back-office development with [laravel/Orchid](https://orchid.software/).

this package is made with the intention to help in your RAPID web development with orchid mainly by providing extra laravel model traits, and extending Orchid's Screens classes  

## Installing Dependencies


The next list of commands must be executed in strictly in the order they are mentioned as packages needed by klorchid:

Create a new laravel Project

    $ composer create-project laravel/laravel brand_new_laravel_project "8.*" --prefer-dist
 
In order to run some migrations  `doctrine\dbal` is needed so you must add it 

    $ composer require doctrine/dbal

Add Laravel's Jetstream dependency (soon to be replaced)

    $ composer require laravel/jetstream
    $ php artisan jetstream:install livewire
    $ npm install && npm run dev
    
As this package is currently on development you need `Debugbar` of barryvdh   perhaps there are some missing `\DebugBar::info()` over there

    $ composer require barryvdh/laravel-debugbar --dev
    

 Then you must set-up/create your[ laravel .env file with all your configs](https://laravel.com/docs/8.x/configuration#environment-configuration), and  with your [database conection paramas](https://laravel.com/docs/8.x/database) .

Lets add Orchid:

    $ composer require orchid/platform
    $ php artisan orchid:install
    
We need to change the "true" value by "false" at the auth entry on the config/platform.php config file in order to use jetstream.

    //config/platform.php
    auth = false; 

## Install

Just add kamansoft/klorchid as normal composer package
    
    $ composer require kamansoft/klorchid
    
Lets set klorchid Kuser model as default model used by auth, so you must change the value of the entry `providers.users.model` from the default `App\Models\User::class` to the klorchid one `Kamansoft\Klorchid\Models\Kuser::class` on the config/auth.php file

    //config/auth.php
    'providers' => [
       'users' => [
           'driver' => 'eloquent',
           'model' => Kamansoft\Klorchid\Models\Kuser::class,
       ],
       .
       .
       .



 Finally we run the klorchid install command 
 
    $ php artisan klorchid:install

    
    
 
    
