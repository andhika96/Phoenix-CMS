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
	<div class="container-fluid">
		<div class="arv6-box bg-white p-3 p-md-4 rounded">
			<div class="h5 pb-3 pb-md-4 mb-4 mb-md-5 mb-xl-4 border-bottom"><i class="fad fa-user-secret fa-fw me-2"></i> Admin Panel</div>

			<div class="row text-center mb-n5">
				<div class="col-6 col-md-3 col-xl-2 mb-5">
					<a href="'.site_url('awesome_admin/config').'" class="text-decoration-none">
						<div class="d-block mb-2">
							<i class="fad fa-cogs fa-4x"></i>
						</div>

						<span class="lead">Configurations</span>
					</a>
				</div>

				<div class="col-6 col-md-3 col-xl-2 mb-5">
					<a href="'.site_url('awesome_admin/pages').'" class="text-decoration-none">
						<div class="d-block mb-2">
							<i class="fad fa-columns fa-4x"></i>
						</div>

						<span class="lead">Pages</span>
					</a>
				</div>

				<div class="col-6 col-md-3 col-xl-2 mb-5">
					<a href="'.site_url('awesome_admin/menus').'" class="text-decoration-none">
						<div class="d-block mb-2">
							<i class="fad fa-bars fa-4x"></i>
						</div>

						<span class="lead">Menus</span>
					</a>
				</div>

				<div class="col-6 col-md-3 col-xl-2 mb-5">
					<a href="'.site_url('awesome_admin/modules').'" class="text-decoration-none">
						<div class="d-block mb-2">
							<i class="fad fa-puzzle-piece fa-4x"></i>
						</div>

						<span class="lead">Modules</span>
					</a>
				</div>

				<div class="col-6 col-md-3 col-xl-2 mb-5">
					<a href="'.site_url('awesome_admin/users').'" class="text-decoration-none">
						<div class="d-block mb-2">
							<i class="fad fa-users fa-4x"></i>
						</div>

						<span class="lead">User\'s</span>
					</a>
				</div>

				<div class="col-6 col-md-3 col-xl-2 mb-5">
					<a href="'.site_url('awesome_admin/roles').'" class="text-decoration-none">
						<div class="d-block mb-2">
							<i class="fad fa-project-diagram fa-4x"></i>
						</div>

						<span class="lead">Roles</span>
					</a>
				</div>

				<div class="col-6 col-md-3 col-xl-2 mb-5">
					<a href="'.site_url('awesome_admin/translate').'" class="text-decoration-none">
						<div class="d-block mb-2">
							<i class="fad fa-language fa-4x"></i>
						</div>

						<span class="lead">Translate</span>
					</a>
				</div>

				<div class="col-6 col-md-3 col-xl-2 mb-5">
					<a href="'.site_url('awesome_admin/smtp').'" class="text-decoration-none">
						<div class="d-block mb-2">
							<i class="fad fa-envelope fa-4x"></i>
						</div>

						<span class="lead">SMTP Settings</span>
					</a>
				</div>

				<div class="col-6 col-md-3 col-xl-2 mb-5">
					<a href="'.site_url('awesome_admin/gmaps').'" class="text-decoration-none">
						<div class="d-block mb-2">
							<i class="fab fa-google fa-4x"></i>
						</div>

						<span class="lead">GMaps API</span>
					</a>
				</div>
			</div>
		</div>
	</div>');

?>