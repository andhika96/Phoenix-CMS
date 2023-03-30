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

	section_content(breadcrumb(['Admin Panel' => site_url('awesome_admin'), 'Translate' => '']));

	section_content('
	<div class="mb-5">
		<div class="arv6-box bg-white p-3 p-md-4 rounded shadow-sm">
			<div class="h5 pb-3 pb-md-4 mb-3 border-bottom d-flex justify-content-between align-items-center"><div><i class="fad fa-language fa-fw fa-lg mr-2"></i> Translate</div> <div class="font-weight-normal font-size-normal"><span class="mr-2">Switch Language:</span> '.init_language().'</div></div>

			<div class="row text-center mb-n5">
				<div class="col-6 col-md-3 col-xl-2 mb-5">
					<a href="'.site_url('awesome_admin/untranslated').'" class="text-decoration-none">
						<div class="fa-layers fa-fw fa-4x d-block mx-auto mb-2">
							<i class="fad fa-language"></i>
							<span class="fa-layers-counter fa-layers-top-right bg-danger shadow-sm" style="right: -11px"><i class="fas fa-times"></i></span>
						</div>

						<span class="lead">Untranslated</span>
					</a>
				</div>

				<div class="col-6 col-md-3 col-xl-2 mb-5">
					<a href="'.site_url('awesome_admin/translated').'" class="text-decoration-none">
						<div class="fa-layers fa-fw fa-4x d-block mx-auto mb-2">
							<i class="fad fa-language"></i>
							<span class="fa-layers-counter fa-layers-top-right bg-success shadow-sm" style="right: -11px"><i class="fas fa-check"></i></span>
						</div>

						<span class="lead">Translated</span>
					</a>
				</div>
			</div>
		</div>
	</div>');

?>