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

	section_content(breadcrumb(['Admin Panel' => site_url('awesome_admin'), 'Menu' => '']));

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

	<div class="mb-5" id="ar-app-listdata">
		<div class="arv6-box bg-white p-3 p-md-4 rounded shadow-sm ar-fetch-listdata-getlistroles" data-url="'.site_url('awesome_admin/getListofRoles').'">
			<div class="h5 pb-3 pb-md-4 mb-4 mb-md-5 mb-xl-4 border-bottom"><i class="fad fa-bars fa-fw me-2"></i> Manage Menu</div>
			<div class="toast ar-notice-toast position-relative bg-transparent align-items-center border-0" role="alert" aria-live="assertive" aria-atomic="true" data-bs-autohide="false"></div>

			<div id="ar-form-submit" class="ar-fetch-listdata-getrolemenus" data-url="'.site_url('awesome_admin/getListRoleofMenus').'">
				<form action="'.site_url('awesome_admin/menus').'" method="post" enctype="multipart/form-data" @submit="submit" button-block="false" font-size-large="false" button-rounded-pill="false" with-list-wopage="true" with-list-slideshow-page="false" with-list-coverimage-page="false" ref="formHTML">
					<table class="table">
						<thead>
							<tr>
								<th scope="col" style="width: 7%">Active</th>
								<th scope="col" style="width: 18%">Menu Name</th>
								<th scope="col" style="width: 40%">Role Permissions</th>
								<th scope="col" style="width: 35%"></th>
							</tr>
						</thead>

						<tbody>');

			$i = 0;
			foreach ($menus as $menu) 
			{
				if ($menu['type'] == 'menu')
				{
					$module_key = $menu['flag'].'_actived';
					$checked 	= (isset($current_modules[$menu['flag']]['actived']) && $current_modules[$menu['flag']]['actived'] == 1) ? 'checked' : '';

					section_content('
						<tr>
							<td class="align-middle">
								<div class="form-check form-switch form-lg">
									<input class="form-check-input" type="checkbox" role="switch" name="'.$module_key.'" value="1" id="'.$module_key.'" '.$checked.'>
								</div>
							</td>
							
							<td class="align-middle">'.$menu['name'].'</td>
							<td class="align-middle">
								<v-select v-model="getSelectedRoleofMenus[\''.$menu['flag'].'\']" :reduce="(getListRoles) => getListRoles.id_in_string" :options="getListRoles" label="name" multiple></v-select>
								<input type="hidden" name="roles['.$menu['flag'].']" :value="getSelectedRoleofMenus[\''.$menu['flag'].'\']">
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