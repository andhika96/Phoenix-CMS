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

	section_content(breadcrumb(['Admin Panel' => site_url('awesome_admin'), 'Modules' => '']));

	section_content('
	<style>
	.form-switch .form-check-input 
	{
		width: 2.5em;
	}	

	.form-check-input
	{
		height: 1.4em;
	}
	</style>

	<div class="mb-5" id="ar-app-form">
		<div class="arv6-box bg-white p-3 p-md-4 rounded shadow-sm">
			<div class="h5 pb-3 pb-md-4 mb-4 mb-md-5 mb-xl-4 border-bottom"><i class="fad fa-puzzle-piece fa-fw me-2"></i> Manage Modules</div>
			<div class="toast ar-notice-toast position-relative bg-transparent align-items-center border-0" role="alert" aria-live="assertive" aria-atomic="true" data-bs-autohide="false"></div>

			<div id="ar-form-submit">
				<form action="'.site_url('awesome_admin/modules').'" method="post" enctype="multipart/form-data" @submit="submit" ref="formHTML" button-block="false" button-rounded-pill="false" font-size-large="false">
					<table class="table">
						<thead>
							<tr>
								<th scope="col" style="width: 5%">#</th>
								<th scope="col" style="width: 15%">Active</th>
								<th scope="col" style="width: 18%">Page Name</th>
								<th scope="col" style="width: 7%">Type</th>
								<th scope="col" style="width: 7%">Version</th>
								<th scope="col" style="width: 52%"></th>
							</tr>
						</thead>

						<tbody>');

			$i = 1;
			foreach ($modules as $module) 
			{				
				$module_key = $module['flag'].'_actived';
				$checked 	= (isset($current_modules[$module['flag']]['actived']) && $current_modules[$module['flag']]['actived'] == 1) ? 'checked' : '';

				section_content('
					<tr>
						<th scope="row">'.$i.'</th>
						<td>
							<div class="form-check form-switch form-lg">');

						if ($module['type'] == 'core')
						{
							section_content('
								<input class="form-check-input" type="checkbox" role="switch" name="'.$module_key.'" value="1" id="'.$module_key.'" checked disabled> <span class="text-danger text-small form-label ms-1"><i>(Disabled)</i></span>');
						}
						else
						{	
							section_content('
								<input class="form-check-input" type="checkbox" role="switch" name="'.$module_key.'" value="1" id="'.$module_key.'" '.$checked.'>');
						}

				section_content('
							</div>
						</td>
						
						<td>'.$module['name'].'</td>
						<td>'.$module['type'].'</td>
						<td>'.$module['version'].'</td>
						<td></td>
					</tr>');

				$i++;
			}

	section_content('
						</tbody>
					</table>

					<div class="row">
						<div class="col text-end">
							<input type="hidden" name="step" value="post">
							<input type="hidden" class="btn-token-submit" name="'.$csrf_name.'" value="'.$csrf_hash.'">
							<input type="submit" class="btn btn-malika-submit font-size-inherit" value="Save">
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>');

?>