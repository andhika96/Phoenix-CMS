<?php

function manage_event_config()
{
	$module['activation'] = 
	[
		'installation' 	=> true
	];	

	$module['list_menu'] =
	[
	 	[
			'name' 	=> 'Manage Event',
			'type' 	=> 'parent',
			'icon' 	=> '<i class="fad fa-newspaper fa-fw me-2"></i>',
			'roles' => '99',
			'path' 	=> ''
		],
		[
			'name' 	=> 'List of Event',
			'type' 	=> 'child',
			'icon' 	=> '<i class="fad fa-list fa-fw me-2"></i>',
			'roles' => '99',
			'path' 	=> 'manage_event'
		],
		[
			'name' 	=> 'Add New',
			'type' 	=> 'child',
			'icon' 	=> '<i class="fad fa-plus fa-fw me-2"></i>',
			'roles' => '99',
			'path' 	=> 'manage_event/addpost'
		],
		[
			'name' 	=> 'Event Categories',
			'type' 	=> 'child',
			'icon' 	=> '<i class="fad fa-folder fa-fw me-2"></i>',
			'roles' => '99',
			'path' 	=> 'manage_event/category'
		],
		[
			'name' 	=> 'Layout',
			'type' 	=> 'child',
			'icon' 	=> '<i class="fad fa-swatchbook fa-fw me-2"></i>',
			'roles' => '99',
			'path' 	=> 'manage_event/layout'
		]
	];

	return $module;
}

?>