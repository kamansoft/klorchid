<?php
return [
    'klorchid_app_folder' => env('KLORCHID_APP_FOLDER', 'Felberg'),
    'models_common_field_names' => [
        'status' => 'status',
        'reason' => 'cur_status_reason',
        'update_time_stamp' => 'updated_at',
        'updater' => 'updated_by',
        'create_time_stamp' => 'created_at',
        'creator' => 'created_by'],
	'screen_query_required_elements' => [
		'element_to_display' => 'element',
		'screen_mode_layout' => 'screen_mode',
		'screen_mode_perms'=>'mode_perms'
        //'screen_action_perms'=>'action_perms'
	],

];