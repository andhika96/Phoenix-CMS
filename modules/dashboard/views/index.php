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

	section_content('
	<div class="arv6-box bg-white rounded shadow-sm d-flex justify-content-center align-items-center p-5">
		<div>
			<img src="'.base_url('assets/images/undraw_a_whole_year_vnfm.svg').'" class="img-fluid mb-4" style="width: 300px">
			<div class="h3 text-center">Welcome, '.get_user('fullname').'</div>
		</div>
	</div>');

?>