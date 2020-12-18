<?php

return [
	'system_user_id' => env('SYSTEM_USER_ID'),
	'aviable_locales' => ['es', 'en'],
    'middleware' => [
        'public'  => ['web'],
        'private' => ['web', 'platform','klorchid'],
    ],
];