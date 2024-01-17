<?php

function manage_promotion_config()
{
	$module['activation'] = 
	[
		'installation' 	=> true
	];

	$module['list_menu'] =
	[
		[
			'name' 	=> 'Manage Promotion',
			'type' 	=> 'parent',
			'icon' 	=> '<i class="fad fa-newspaper fa-fw me-2"></i>',
			'roles' => '99',
			'path' 	=> ''
		],
		[
			'name' 	=> 'List of Promotion',
			'type' 	=> 'child',
			'icon' 	=> '<i class="fad fa-list fa-fw me-2"></i>',
			'roles' => '99',
			'path' 	=> 'manage_promotion'
		],
		[
			'name' 	=> 'Add New',
			'type' 	=> 'child',
			'icon' 	=> '<i class="fad fa-plus fa-fw me-2"></i>',
			'roles' => '99',
			'path' 	=> 'manage_promotion/addpost'
		],
		[
			'name' 	=> 'Promotion Categories',
			'type' 	=> 'child',
			'icon' 	=> '<i class="fad fa-folder fa-fw me-2"></i>',
			'roles' => '99',
			'path' 	=> 'manage_promotion/category'
		],
		[
			'name' 	=> 'Layout',
			'type' 	=> 'child',
			'icon' 	=> '<i class="fad fa-swatchbook fa-fw me-2"></i>',
			'roles' => '99',
			'path' 	=> 'manage_promotion/layout'
		]
	];

	return $module;
}

?>