<?php

function manage_aboutus_config()
{
	$module['activation'] = 
	[
		'installation' 	=> true
	];	

	$module['list_menu'] =
	[
		[
			'name' 	=> 'Manage About Us',
			'type' 	=> 'parent',
			'icon' 	=> '<i class="fad fa-address-card fa-fw me-2"></i>',
			'roles' => '99',
			'path' 	=> ''
		],
		[
			'name' 	=> 'About Us 1',
			'type' 	=> 'child',
			'icon' 	=> '<i class="fad fa-address-card fa-fw me-2"></i>',
			'roles' => '99',
			'path' 	=> 'manage_aboutus'
		],
		[
			'name' 	=> 'About Us 2',
			'type' 	=> 'child',
			'icon' 	=> '<i class="fad fa-address-card fa-fw me-2"></i>',
			'roles' => '99',
			'path' 	=> 'manage_aboutus'
		]
	];

	return $module;
}

?>