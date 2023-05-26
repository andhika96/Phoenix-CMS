<?php

/*
 * Available config
 * 
 * Slideshow, Cover Image, Widget, and Carousel
 * 
 * You can set 1 to activate and set 0 to deactivate
 * For active_slideshow and active_coverimage you can only choose one and cannot active at the same time
 *
 * @return array	
 */

function contact_install()
{
	$config =
	[
		'active_slideshow'	=> 0,
		'active_coverimage'	=> 0,
		'active_widget'		=> 0
	];

	return $config;
}

?>