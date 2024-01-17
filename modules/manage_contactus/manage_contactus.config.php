<?php

function manage_contactus_config()
{
	$module['activation'] = 
	[
		'installation' 	=> true
	];	

	$module['list_menu'] =
	[
		[
			'name' 	=> 'Manage Contact Us',
			'type' 	=> 'parent',
			'icon' 	=> '<i class="fad fa-phone fa-fw me-2"></i>',
			'roles' => '99',
			'path' 	=> ''
		],
		[
			'name' 	=> 'Manage Contact Us',
			'type' 	=> 'single',
			'icon' 	=> '<i class="fad fa-phone fa-fw me-2"></i>',
			'roles' => '99',
			'path' 	=> 'manage_contactus'
		]
	];

	return $module;
}

?>