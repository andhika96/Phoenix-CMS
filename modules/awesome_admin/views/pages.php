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

	section_content(breadcrumb(['Admin Panel' => site_url('awesome_admin'), 'Pages' => '']));

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
			<div class="h5 pb-3 pb-md-4 mb-4 mb-md-5 mb-xl-4 border-bottom"><i class="fad fa-columns fa-fw me-2"></i> Manage Pages</div>
			<div class="toast ar-notice-toast position-relative bg-transparent align-items-center border-0" role="alert" aria-live="assertive" aria-atomic="true" data-bs-autohide="false"></div>

			<div id="ar-form-submit">
				<form action="'.site_url('awesome_admin/pages').'" method="post" enctype="multipart/form-data" @submit="submit" ref="formHTML" button-block="false" button-rounded-pill="false" font-size-large="false">
					<table class="table">
						<thead>
							<tr>
								<th scope="col" style="width: 5%">#</th>
								<th scope="col" style="width: 7%">Active</th>
								<th scope="col" style="width: 18%">Page Name</th>
								<th scope="col" style="width: 12%">Slideshow</th>
								<th scope="col" style="width: 12%">Cover Image</th>
								<th scope="col" style="width: 12%">Widget</th>
								<th scope="col" style="width: 12%">Position</th>
								<th scope="col" style="width: 34%"></th>
							</tr>
						</thead>

						<tbody>');

			$i = 1;
			foreach ($pages as $page) 
			{
				if ($page['type'] == 'page')
				{
					$module_key 		= $page['flag'].'_actived';
					$module_slideshow 	= $page['flag'].'_slideshow';
					$module_coverimage 	= $page['flag'].'_coverimage';
					$module_widget 		= $page['flag'].'_widget';
					$module_position 	= $page['flag'].'_position';

					$checked 			= (isset($current_modules[$page['flag']]['actived']) && $current_modules[$page['flag']]['actived'] == 1) ? 'checked' : '';
					$checked_slideshow 	= (isset($current_modules[$page['flag']]['is_slideshow']) && $current_modules[$page['flag']]['is_slideshow'] == 1) ? 'checked' : '';
					$checked_coverimage = (isset($current_modules[$page['flag']]['is_coverimage']) && $current_modules[$page['flag']]['is_coverimage'] == 1) ? 'checked' : '';
					$checked_widget 	= (isset($current_modules[$page['flag']]['is_widget']) && $current_modules[$page['flag']]['is_widget'] == 1) ? 'checked' : '';

					section_content('
						<tr>
							<th scope="row">'.$i.'</th>
							<td>
								<div class="form-check form-switch form-lg">
									<input class="form-check-input" type="checkbox" role="switch" name="'.$module_key.'" value="1" id="'.$module_key.'" '.$checked.'>
								</div>
							</td>
							
							<td>'.$page['name'].'</td>
							<td>
								<div class="form-check form-switch form-lg">
									<input class="form-check-input" type="checkbox" role="switch" name="'.$module_slideshow.'" value="1" id="'.$module_slideshow.'" '.$checked_slideshow.'>
								</div>
							</td>
							
							<td>
								<div class="form-check form-switch form-lg">
									<input class="form-check-input" type="checkbox" role="switch" name="'.$module_coverimage.'" value="1" id="'.$module_coverimage.'" '.$checked_coverimage.'>
								</div>
							</td>

							<td>
								<div class="form-check form-switch form-lg">
									<input class="form-check-input" type="checkbox" role="switch" name="'.$module_widget.'" value="1" id="'.$module_widget.'" '.$checked_widget.'>
								</div>
							</td>
							
							<td>
								<input type="text" name="'.$module_position.'" class="form-control font-size-inherit" value="'.$current_modules[$page['flag']]['position'].'">
							</td>

							<td></td>
						</tr>');

					$i++;
				}
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