<?php

return [
	'system_user_id' => env('SYSTEM_USER_ID'),
	'available locales' => ['es', 'en'],
    'klorchid_app_folder' => env('KLORCHID_APP_FOLDER','Klorchid'),
    'models_common_field_names'=>[
        'status'=>'status',
        'reason'=>'cur_status_reason',
        'last_updater'=>'updated_by',
        'creator'=>'created_by'
    ]
];