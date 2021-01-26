<?php

return [
	'system_user_id' => env('SYSTEM_USER_ID'),
	'aviable_locales' => ['es', 'en'],
    'models_common_field_names'=>[
        'status'=>'status',
        'reason'=>'cur_status_reason',
        'last_updater'=>'updated_by',
        'creator'=>'created_by'
    ]
];