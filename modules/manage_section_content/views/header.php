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
				<div class="row g-2 mb-4">
					<label for="LabelforMenuPosition" class="col-md-3 col-form-label offset-md-1 pr-md-0 text-md-end">'.t('Menu Position').'</label>
					
					<div class="col-md-4">
						<select name="menu_position" class="form-select font-size-inherit" aria-label="Form Select Menu Position">
							<option value="">Select</option>
							<option value="left" '.$menu_position[0].'>Left Side</option>
							<option value="center" '.$menu_position[1].'>Center</option>
							<option value="right" '.$menu_position[2].'>Right Side</option>
						</select>
					</div>
				</div>

				<div class="row g-2 mb-4">
					<label for="LabelforHeaderType" class="col-md-3 col-form-label offset-md-1 pr-md-0 text-md-end">'.t('Header Type').'</label>
					
					<div class="col-md-4">
						<select name="section_type" class="form-select font-size-inherit" aria-label="Form Select Header Type">
							<option value="">Select</option>
							<option value="default" '.$section_type[0].'>Default</option>
							<option value="fixed-top" '.$section_type[1].'>Fixed Top</option>
							<option value="sticky-top" '.$section_type[2].'>Sticky Top</option>
						</select>
					</div>
				</div>

				<div class="row g-2 mb-4">
					<label for="LabelforBackgroundColor" class="col-md-3 col-form-label offset-md-1 pr-md-0 text-md-end">'.t('Background Color').'</label>
					
					<div class="col-md-4">
						<input type="text" name="background_color" class="form-control font-size-inherit color-picker-for-jquery" value="'.$row['background_color'].'">
					</div>
				</div>

				<div class="row g-2 mb-4">
					<label for="LabelforBackgroundColorActive" class="col-md-3 col-form-label offset-md-1 pr-md-0 text-md-end">'.t('Background Color Active').'</label>
					
					<div class="col-md-4">
						<input type="text" name="background_color_active" class="form-control font-size-inherit color-picker-for-jquery" value="'.$row['background_color_active'].'" disabled>
						<div class="badge rounded-pill text-bg-info text-small mt-2">Coming soon</div>
					</div>
				</div>

				<div class="row g-2 mb-4">
					<label for="LabelforLinkColor" class="col-md-3 col-form-label offset-md-1 pr-md-0 text-md-end">'.t('Link Color').'</label>
					
					<div class="col-md-4">
						<input type="text" name="link_color" class="form-control font-size-inherit color-picker-for-jquery" value="'.$row['link_color'].'">
					</div>
				</div>

				<div class="row g-2 mb-4">
					<label for="LabelforBackgroundLinkColor" class="col-md-3 col-form-label offset-md-1 pr-md-0 text-md-end">'.t('Background Link Color').'</label>
					
					<div class="col-md-4">
						<input type="text" name="background_link_color" class="form-control font-size-inherit color-picker-for-jquery" value="'.$row['background_link_color'].'">
					</div>
				</div>

				<div class="row g-2 mb-4">
					<label for="LabelforLinkColorHover" class="col-md-3 col-form-label offset-md-1 pr-md-0 text-md-end">'.t('Link Color Hover').'</label>
					
					<div class="col-md-4">
						<input type="text" name="link_color_hover" class="form-control font-size-inherit color-picker-for-jquery" value="'.$row['link_color_hover'].'">
					</div>
				</div>

				<div class="row g-2 mb-4">
					<label for="LabelforBackgroundLinkColorHover" class="col-md-3 col-form-label offset-md-1 pr-md-0 text-md-end">'.t('Background Link Color Hover').'</label>
					
					<div class="col-md-4">
						<input type="text" name="background_link_color_hover" class="form-control font-size-inherit color-picker-for-jquery" value="'.$row['background_link_color_hover'].'">
					</div>
				</div>

				<div class="row g-2 mb-4">
					<label for="LabelforLinkColorActive" class="col-md-3 col-form-label offset-md-1 pr-md-0 text-md-end">'.t('Link Color Active').'</label>
					
					<div class="col-md-4">
						<input type="text" name="link_color_active" class="form-control font-size-inherit color-picker-for-jquery" value="'.$row['link_color_active'].'">
					</div>
				</div>

				<div class="row g-2 mb-4">
					<label for="LabelforBackgroundLinkColorActive" class="col-md-3 col-form-label offset-md-1 pr-md-0 text-md-end">'.t('Background Link Color Active').'</label>
					
					<div class="col-md-4">
						<input type="text" name="background_link_color_active" class="form-control font-size-inherit color-picker-for-jquery" value="'.$row['background_link_color_active'].'">
					</div>
				</div>

				<div class="row g-2 mb-4">
					<label for="LabelforMarginLink" class="col-md-3 col-form-label offset-md-1 pr-md-0 text-md-end">'.t('Margin Link').'</label>
					
					<div class="col-md-1">
						<input type="text" name="margin_top_link" class="form-control font-size-inherit" placeholder="Top" value="'.$row['margin_top_link'].'">
					</div>
					
					<div class="col-md-1">
						<input type="text" name="margin_right_link" class="form-control font-size-inherit" placeholder="Right" value="'.$row['margin_right_link'].'">
					</div>
					
					<div class="col-md-1">
						<input type="text" name="margin_bottom_link" class="form-control font-size-inherit" placeholder="Bottom" value="'.$row['margin_bottom_link'].'">
					</div>

					<div class="col-md-1">
						<input type="text" name="margin_left_link" class="form-control font-size-inherit" placeholder="Left" value="'.$row['margin_left_link'].'">
					</div>
				</div>

				<div class="row g-2 mb-4">
					<label for="LabelforPaddingLink" class="col-md-3 col-form-label offset-md-1 pr-md-0 text-md-end">'.t('Padding Link').'</label>
					
					<div class="col-md-1">
						<input type="text" name="padding_top_link" class="form-control font-size-inherit" placeholder="Top" value="'.$row['padding_top_link'].'">
					</div>
					
					<div class="col-md-1">
						<input type="text" name="padding_right_link" class="form-control font-size-inherit" placeholder="Right" value="'.$row['padding_right_link'].'">
					</div>
					
					<div class="col-md-1">
						<input type="text" name="padding_bottom_link" class="form-control font-size-inherit" placeholder="Bottom" value="'.$row['padding_bottom_link'].'">
					</div>

					<div class="col-md-1">
						<input type="text" name="padding_left_link" class="form-control font-size-inherit" placeholder="Left" value="'.$row['padding_left_link'].'">
					</div>
				</div>

				<div class="row g-2 mb-4">
					<label for="LabelforLinkBorderRadius" class="col-md-3 col-form-label offset-md-1 pr-md-0 text-md-end">'.t('Link Border Radius').'</label>
					
					<div class="col-md-4">
						<input type="text" name="link_border_radius" class="form-control font-size-inherit" value="'.$row['link_border_radius'].'">
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