<?php

function manage_portofolio_config()
{
	$module['activation'] = 
	[
		'installation' 	=> true
	];	
	
	$module['list_menu'] =
	[
		[
			'name' 	=> 'Manage Portofolio',
			'type' 	=> 'parent',
			'icon' 	=> '<i class="fad fa-newspaper fa-fw me-2"></i>',
			'roles' => '99',
			'path' 	=> ''
		],
		[
			'name' 	=> 'List of Portofolio',
			'type' 	=> 'child',
			'icon' 	=> '<i class="fad fa-list fa-fw me-2"></i>',
			'roles' => '99',
			'path' 	=> 'manage_portofolio'
		],
		[
			'name' 	=> 'Add New',
			'type' 	=> 'child',
			'icon' 	=> '<i class="fad fa-plus fa-fw me-2"></i>',
			'roles' => '99',
			'path' 	=> 'manage_portofolio/addpost'
		],
		[
			'name' 	=> 'Portofolio Categories',
			'type' 	=> 'child',
			'icon' 	=> '<i class="fad fa-folder fa-fw me-2"></i>',
			'roles' => '99',
			'path' 	=> 'manage_portofolio/category'
		],
		[
			'name' 	=> 'Layout',
			'type' 	=> 'child',
			'icon' 	=> '<i class="fad fa-swatchbook fa-fw me-2"></i>',
			'roles' => '99',
			'path' 	=> 'manage_portofolio/layout'
		]
	];

	return $module;
}

?>