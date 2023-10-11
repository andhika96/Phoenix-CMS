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

	section_content(breadcrumb([t('Manage Section Content') => '', t('Header Section') => '']));

	section_content('
	<div class="container-fluid px-0" id="ar-app-listdata">
		<div class="arv6-box bg-white arv3-pc-content p-4 p-md-5 rounded shadow-sm" id="ar-form-submit">
			<div class="toast ar-notice-toast position-relative bg-transparent align-items-center border-0" role="alert" aria-live="assertive" aria-atomic="true" data-bs-autohide="false"></div>

			<form action="'.site_url('manage_section_content/header').'" method="post" @submit="submit" button-block="false" font-size-large="false" button-rounded-pill="false" with-list-wopage="true" with-list-slideshow-page="false" with-list-coverimage-page="false" ref="formHTML">
				<!-- Link Section -->
				<div class="mb-5">
					<div class="row g-2 mb-4">
						<div class="col-12 col-sm-8 mx-auto">
							<h5 class="ps-3 mb-0" style="border-left: 5px solid #0095c8;">'.t('Menu Settings').'</h5>
						</div>
					</div>

					<div class="row g-2 mb-4">
						<label for="LabelforHeaderPlacement" class="col-md-3 col-form-label offset-md-1 pr-md-0 text-md-end">'.t('Header Placement').'</label>
						
						<div class="col-md-4">
							<select name="vars_1[navbar][menu][placement]" class="form-select font-size-inherit" aria-label="Form Select Header Type">
								<option value="">Select</option>
								<option value="default" '.$section_type[0].'>Default</option>
								<option value="fixed-top" '.$section_type[1].'>Fixed Top</option>
								<option value="sticky-top" '.$section_type[2].'>Sticky Top</option>
							</select>
						</div>
					</div>

					<div class="row g-2 mb-4">
						<label for="LabelforMenuPosition" class="col-md-3 col-form-label offset-md-1 pr-md-0 text-md-end">'.t('Menu Position').'</label>
						
						<div class="col-md-4">
							<select name="vars_1[navbar][menu][position]" class="form-select font-size-inherit" aria-label="Form Select Menu Position">
								<option value="">Select</option>
								<option value="left" '.$menu_position[0].'>Left Side</option>
								<option value="center" '.$menu_position[1].'>Center</option>
								<option value="right" '.$menu_position[2].'>Right Side</option>
							</select>
						</div>
					</div>
				</div>

				<!-- Margin Section -->
				<div class="mb-5">
					<div class="row g-2 mb-4">
						<div class="col-12 col-sm-8 mx-auto">
							<h5 class="ps-3 mb-0" style="border-left: 5px solid #0095c8;">'.t('Background Style').'</h5>
						</div>
					</div>

					<div class="row g-2 mb-4">
						<label for="LabelforBackgroundColorDefault" class="col-md-3 col-form-label offset-md-1 pr-md-0 text-md-end">'.t('Background Color Default').'</label>
						
						<div class="col-md-4">
							<input type="text" name="vars_1[navbar][background][color_default]" class="form-control font-size-inherit color-picker-for-jquery" placeholder="#fff" value="'.$vars['navbar']['background']['color_default'].'">
						</div>
					</div>

					<div class="row g-2 mb-4">
						<label for="LabelforBackgroundColorActive" class="col-md-3 col-form-label offset-md-1 pr-md-0 text-md-end">'.t('Background Color Active').'</label>
						
						<div class="col-md-4">
							<input type="text" name="vars_1[navbar][background][color_active]" class="form-control font-size-inherit color-picker-for-jquery" placeholder="#fff" value="'.$vars['navbar']['background']['color_active'].'">
						</div>
					</div>

					<div class="row g-2 mb-4">
						<label for="LabelforBorderBottom" class="col-md-3 col-form-label offset-md-1 pr-md-0 text-md-end">'.t('Border Bottom Color').'</label>
						
						<div class="col-md-4">
							<input type="text" name="vars_1[navbar][background][border-bottom]" class="form-control font-size-inherit color-picker-for-jquery" placeholder="#fff" value="'.$vars['navbar']['background']['border-bottom'].'">
						</div>
					</div>

					<div class="row g-2 mb-4">
						<label for="LabelforBackgroundShadow" class="col-md-3 col-form-label offset-md-1 pr-md-0 text-md-end">'.t('Background Shadow').'</label>
						
						<div class="col-md-4">
							<select name="vars_1[navbar][background][shadow]" class="form-select font-size-inherit" aria-label="Form Select Header Type">
								<option value="">Select</option>
								<option value="shadow-none" '.$background_shadow[0].'>No Shadow</option>
								<option value="shadow-sm" '.$background_shadow[1].'>Small Shadow</option>
								<option value="shadow" '.$background_shadow[2].'>Normal Shadow</option>
								<option value="shadow-lg" '.$background_shadow[2].'>Large Shadow</option>
							</select>
						</div>
					</div>
				</div>

				<!-- Other Settings -->
				<div class="mb-5">
					<div class="row g-2 mb-4">
						<div class="col-12 col-sm-8 mx-auto">
							<h5 class="ps-3 mb-0" style="border-left: 5px solid #0095c8;">'.t('Other Settings').'</h5>
						</div>
					</div>

					<div class="row g-3 mx-auto">
						<div class="col-md-2 offset-md-4 text-md-end">
							<a href="'.site_url('manage_section_content/header_menu/main_menu').'" class="btn btn-primary font-size-inherit">Main Menu Settings</a>
						</div>

						<div class="col-md-2 text-md-end">
							<a href="'.site_url('manage_section_content/header_menu/aside_menu').'" class="btn btn-primary font-size-inherit">Aside Menu Settings</a>
						</div>
					</div>
				</div>

				<div class="row">
					<div class="col-md-4 offset-md-4 mt-2 text-end">
						<input type="hidden" name="step" value="post">
						<input type="hidden" class="btn-token-submit" name="'.$csrf_name.'" value="'.$csrf_hash.'">
						<input type="submit" class="btn btn-bnight-blue btn-malika-submit font-size-inherit" value="'.t('Save').'">
					</div>
				</div>
			</form>
		</div>
	</div>');

?>