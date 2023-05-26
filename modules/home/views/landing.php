<?php

	/*
	 *	Aruna Development Project
	 *	IS NOT FREE SOFTWARE
	 *	Codename: Aruna Personal Site
	 *	Source: Based on Sosiaku Social Networking Software
	 *	Website: https://www.sosiaku.gq
	 *	Website: https://www.aruna-dev.id
	 *	Created and developed by Andhika Adhitia N
	 */

	defined('MODULEPATH') OR exit('No direct script access allowed');

	add_title_widget('Portofolio', ['for_widget' => 'portofolio']);
	add_caption_widget('find the latest news from us', ['for_widget' => 'portofolio']);

	add_title_widget('News', ['for_widget' => 'news']);
	add_caption_widget('find the latest news from us', ['for_widget' => 'news']);

	add_title_widget('Event', ['for_widget' => 'event']);
	add_caption_widget('find the latest event from us', ['for_widget' => 'event']);

	section_content('
	<div class="container my-5">
		<div>
			'.add_widget('portofolio', 'grid_box').'
		</div>

		<div>
			'.add_widget('news', 'grid').'
		</div>

		<div>
			'.add_widget('event', 'grid_box').'
		</div>
	</div>');

?>