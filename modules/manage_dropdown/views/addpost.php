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

	section_content(breadcrumb([t('Manage Dropdown') => site_url('manage_dropdown'), t('Add New Dropdown') => '']));

	section_content('
	<div class="container-fluid px-0" id="ar-app-listdata-dropdown">
		<div class="arv6-box bg-white arv3-pc-content p-4 p-md-5 rounded shadow-sm" id="ar-form-submit">
			<div class="toast ar-notice-toast position-relative bg-transparent align-items-center border-0" role="alert" aria-live="assertive" aria-atomic="true" data-bs-autohide="false"></div>

			<form action="'.site_url('manage_dropdown/addpost').'" method="post" @submit="submit" button-block="false" font-size-large="false" button-rounded-pill="false" with-list-wopage="true" with-list-slideshow-page="false" with-list-coverimage-page="false" ref="formHTML">
				<div class="row">
					<label class="col-md-3 col-form-label offset-md-1 pr-md-0 text-md-end">'.t('Dropdown Type').'</label>

					<div class="col-md-5 mb-3">
						<select name="dropdown_type" class="form-select font-size-inherit" aria-label="Select Menu Type" v-on:change="selectCategory($event)">
							<option value="">Select</option>
							<option value="normal_menu">Normal Menu</option>
							<option value="mega_menu">Mega Menu</option>
						</select>
					</div>
				
					<label class="col-md-3 col-form-label offset-md-1 pr-md-0 text-md-end">'.t('Lists of Page').'</label>
					
					<div class="col-md-5 mb-3">
						<select name="page_id" class="form-select font-size-inherit" aria-label="Select Page">
							<option value="">Select Page</option>');
							
					foreach ($menus as $key => $value) 
					{	
						section_content('
							<option value="'.$value['id'].'">'.ucfirst($value['name']).'</option>');
					}

	section_content('
						</select>
					</div>
				</div>

				<div class="row">
					<div class="col-md-4 offset-md-5 text-end">
						<input type="hidden" name="step" value="post">
						<input type="hidden" class="btn-token-submit" name="'.$csrf_name.'" value="'.$csrf_hash.'">
						<input type="submit" class="btn btn-bnight-blue btn-malika-submit font-size-inherit" value="'.t('Add').'">
					</div>
				</div>
			</form>
		</div>
	</div>');

?>