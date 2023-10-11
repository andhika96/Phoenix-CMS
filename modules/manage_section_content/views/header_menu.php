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

	section_content(breadcrumb([t('Manage Section Content') => '', t('Header Section') => site_url('manage_section_content/header'), $section_name => '']));

	section_content('
	<div class="container-fluid px-0" id="ar-app-listdata">
		<div class="arv6-box bg-white arv3-pc-content p-4 p-md-5 rounded shadow-sm" id="ar-form-submit">
			<div class="toast ar-notice-toast position-relative bg-transparent align-items-center border-0" role="alert" aria-live="assertive" aria-atomic="true" data-bs-autohide="false"></div>

			<form action="'.site_url('manage_section_content/header_menu/'.$section.'').'" method="post" @submit="submit" button-block="false" font-size-large="false" button-rounded-pill="false" with-list-wopage="true" with-list-slideshow-page="false" with-list-coverimage-page="false" ref="formHTML">
				<!-- Link Section -->
				<div class="mb-5">
					<div class="row g-2 mb-4">
						<div class="col-12 col-sm-8 mx-auto">
							<h5 class="ps-3 mb-0" style="border-left: 5px solid #0095c8;">'.t('Link Color').'</h5>
						</div>
					</div>

					<div class="row g-2 mb-4">
						<label for="LabelforLinkColorDefault" class="col-md-3 col-form-label offset-md-1 pr-md-0 text-md-end">'.t('Link Color Default').'</label>
						
						<div class="col-md-4">
							<input type="text" name="vars_2['.$section.'][link][color_default]" class="form-control font-size-inherit color-picker-for-jquery" value="'.$vars[$section]['link']['color_default'].'">
						</div>
					</div>

					<div class="row g-2 mb-4">
						<label for="LabelforLinkColorHover" class="col-md-3 col-form-label offset-md-1 pr-md-0 text-md-end">'.t('Link Color Hover').'</label>
						
						<div class="col-md-4">
							<input type="text" name="vars_2['.$section.'][link][color_hover]" class="form-control font-size-inherit color-picker-for-jquery" value="'.$vars[$section]['link']['color_hover'].'">
						</div>
					</div>

					<div class="row g-2 mb-4">
						<label for="LabelforLinkColorActive" class="col-md-3 col-form-label offset-md-1 pr-md-0 text-md-end">'.t('Link Color Active').'</label>
						
						<div class="col-md-4">
							<input type="text" name="vars_2['.$section.'][link][color_active]" class="form-control font-size-inherit color-picker-for-jquery" value="'.$vars[$section]['link']['color_active'].'">
						</div>
					</div>

					<div class="row g-2 mb-4">
						<label for="LabelforLinkColorDefault" class="col-md-3 col-form-label offset-md-1 pr-md-0 text-md-end">'.t('Background Link Color Default').'</label>
						
						<div class="col-md-4">
							<input type="text" name="vars_2['.$section.'][link][background_color_default]" class="form-control font-size-inherit color-picker-for-jquery" value="'.$vars[$section]['link']['background_color_default'].'">
						</div>
					</div>

					<div class="row g-2 mb-4">
						<label for="LabelforLinkColorHover" class="col-md-3 col-form-label offset-md-1 pr-md-0 text-md-end">'.t('Background Link Color Hover').'</label>
						
						<div class="col-md-4">
							<input type="text" name="vars_2['.$section.'][link][background_color_hover]" class="form-control font-size-inherit color-picker-for-jquery" value="'.$vars[$section]['link']['background_color_hover'].'">
						</div>
					</div>

					<div class="row g-2 mb-4">
						<label for="LabelforLinkColorActive" class="col-md-3 col-form-label offset-md-1 pr-md-0 text-md-end">'.t('Background Link Color Active').'</label>
						
						<div class="col-md-4">
							<input type="text" name="vars_2['.$section.'][link][background_color_active]" class="form-control font-size-inherit color-picker-for-jquery" value="'.$vars[$section]['link']['background_color_active'].'">
						</div>
					</div>
				</div>

				<!-- Margin Section -->
				<div class="mb-5">
					<div class="row g-2 mb-4">
						<div class="col-12 col-sm-8 mx-auto">
							<h5 class="ps-3 mb-0" style="border-left: 5px solid #0095c8;">'.t('Link Margin').'</h5>
						</div>
					</div>

					<div class="row g-2 mb-4">
						<label for="LabelforMarginLink" class="col-md-3 col-form-label offset-md-1 pr-md-0 text-md-end">'.t('Margin Position').'</label>
						
						<div class="col-md-1">
							<input type="text" name="vars_2['.$section.'][margin][top]" class="form-control font-size-inherit" placeholder="Top" value="'.$vars[$section]['margin']['top'].'">
						</div>
						
						<div class="col-md-1">
							<input type="text" name="vars_2['.$section.'][margin][right]" class="form-control font-size-inherit" placeholder="Right" value="'.$vars[$section]['margin']['right'].'">
						</div>
						
						<div class="col-md-1">
							<input type="text" name="vars_2['.$section.'][margin][bottom]" class="form-control font-size-inherit" placeholder="Bottom" value="'.$vars[$section]['margin']['bottom'].'">
						</div>

						<div class="col-md-1">
							<input type="text" name="vars_2['.$section.'][margin][left]" class="form-control font-size-inherit" placeholder="Left" value="'.$vars[$section]['margin']['left'].'">
						</div>
					</div>
				</div>

				<!-- Padding Section -->
				<div class="mb-5">
					<div class="row g-2 mb-4">
						<div class="col-12 col-sm-8 mx-auto">
							<h5 class="ps-3 mb-0" style="border-left: 5px solid #0095c8;">'.t('Link Padding').'</h5>
						</div>
					</div>

					<div class="row g-2 mb-4">
						<label for="LabelforPaddingPosition" class="col-md-3 col-form-label offset-md-1 pr-md-0 text-md-end">'.t('Padding Position').'</label>
						
						<div class="col-md-1">
							<input type="text" name="vars_2['.$section.'][padding][top]" class="form-control font-size-inherit" placeholder="Top" value="'.$vars[$section]['padding']['top'].'">
						</div>
						
						<div class="col-md-1">
							<input type="text" name="vars_2['.$section.'][padding][right]" class="form-control font-size-inherit" placeholder="Right" value="'.$vars[$section]['padding']['right'].'">
						</div>
						
						<div class="col-md-1">
							<input type="text" name="vars_2['.$section.'][padding][bottom]" class="form-control font-size-inherit" placeholder="Bottom" value="'.$vars[$section]['padding']['bottom'].'">
						</div>

						<div class="col-md-1">
							<input type="text" name="vars_2['.$section.'][padding][left]" class="form-control font-size-inherit" placeholder="Left" value="'.$vars[$section]['padding']['left'].'">
						</div>
					</div>
				</div>

				<!-- Border Section -->
				<div>
					<div class="row g-2 mb-4">
						<div class="col-12 col-sm-8 mx-auto">
							<h5 class="ps-3 mb-0" style="border-left: 5px solid #0095c8;">'.t('Link Border').'</h5>
						</div>
					</div>

					<div class="row g-2 mb-4">
						<label for="LabelforBorderColor" class="col-md-3 col-form-label offset-md-1 pr-md-0 text-md-end">'.t('Border Color').'</label>
						
						<div class="col-md-4">
							<input type="text" name="vars_2['.$section.'][border][color]" class="form-control font-size-inherit color-picker-for-jquery" value="'.$vars[$section]['border']['color'].'">
						</div>
					</div>

					<div class="row g-2 mb-4">
						<label for="LabelforBorderWidth" class="col-md-3 col-form-label offset-md-1 pr-md-0 text-md-end">'.t('Border Width').'</label>
						
						<div class="col-md-4">
							<input type="text" name="vars_2['.$section.'][border][width]" class="form-control font-size-inherit" value="'.$vars[$section]['border']['width'].'">
						</div>
					</div>

					<div class="row g-2 mb-4">
						<label for="LabelforBorderStyle" class="col-md-3 col-form-label offset-md-1 pr-md-0 text-md-end">'.t('Border Radius').'</label>
						
						<div class="col-md-1">
							<input type="text" name="vars_2['.$section.'][border][radius][top-left]" class="form-control font-size-inherit" placeholder="Top" value="'.$vars[$section]['border']['radius']['top-left'].'">
						</div>
						
						<div class="col-md-1">
							<input type="text" name="vars_2['.$section.'][border][radius][top-right]" class="form-control font-size-inherit" placeholder="Right" value="'.$vars[$section]['border']['radius']['top-right'].'">
						</div>
						
						<div class="col-md-1">
							<input type="text" name="vars_2['.$section.'][border][radius][bottom-left]" class="form-control font-size-inherit" placeholder="Bottom" value="'.$vars[$section]['border']['radius']['bottom-left'].'">
						</div>

						<div class="col-md-1">
							<input type="text" name="vars_2['.$section.'][border][radius][bottom-right]" class="form-control font-size-inherit" placeholder="Left" value="'.$vars[$section]['border']['radius']['bottom-right'].'">
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