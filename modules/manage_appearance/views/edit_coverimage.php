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

	section_content(breadcrumb([t('Manage Appearance') => '', t('Cover Image') => site_url('manage_appearance/coverimage'), t('Edit Cover Image {1}', ucfirst($row['uri'])) => '']));

	section_content('
	<style>
	.sp-original-input-container
	{
		width: 100%;
	}
	</style>

	<div class="container-fluid px-0 mb-5">
		<div class="bg-white arv3-pc-content p-3 p-md-4 rounded shadow-sm" id="ar-app-listdata">
			<div class="h5 pb-3 pb-md-4 mb-3 border-bottom d-flex justify-content-between align-items-center">
				<div>
					<i class="fad fa-images fa-fw me-2"></i> '.t('Edit Cover Image {1}', ucfirst($row['uri'])).'
				</div> 

				<div class="d-none">
					<span class="float-md-right font-size-normal"><a href="javascript:void(0)" v-on:click="addFormCoverimage">New Form</a></span>
				</div>
			</div>

			<div id="ar-form-submit">
				<form action="'.site_url('manage_appearance/edit_coverimage/'.$uri).'" method="post" @submit="submit" button-block="false" font-size-large="false" button-rounded-pill="false" with-list-wopage="false" with-list-slideshow-page="false" with-list-coverimage-page="true" ref="formHTML">
					<div class="toast ar-notice-toast position-relative bg-transparent align-items-center border-0" role="alert" aria-live="assertive" aria-atomic="true" data-bs-autohide="false"></div>

					<div v-if="loadingCoverimagePage" class="text-center p-5">
						<div class="spinner-border text-primary mb-2" role="status">
							<span class="visually-hidden">Loading...</span>
						</div>

						<div class="h6">Loading ...</div>
					</div>

					<div v-else class="ar-data-load" style="display: none">
						<div class="row ar-fetch-listdata-coverimage" data-url="'.site_url('manage_appearance/getListCoverimage/'.$uri).'">
							<div class="col-12 mb-4" v-for="(info, index) in getListFormCoverimage" :key="index">
								<div class="row mb-3">
									<div class="col-12">
										<h6 class="mb-0 pb-3 border-bottom">- Image</h6>
									</div>
								</div>

								<label class="form-label">For Web</label>								

								<div class="input-group mb-4">
									<input type="file" :name="\'image_web_\'+index+\'\'" class="form-control font-size-inherit" id="formFileImageWeb" aria-label="Form Image For Web" aria-describedby="button-addon2" v-model="info.image_web_for_file">
									
									<span v-if="info.image_web !== \'\'" class="input-group-text font-size-inherit">
										<a :href="\''.base_url('\'+info.image_web+\'').'\'" class="font-size-inherit text-decoration-none text-success" target="_blank">Preview</a>
									</span>
								</div>

								<label class="form-label">For Mobile</label>									

								<div class="input-group mb-5">
									<input type="file" :name="\'image_mobile_\'+index+\'\'" class="form-control font-size-inherit" id="formFileImageMobile" aria-label="Form Image For Mobile" aria-describedby="button-addon2" v-model="info.image_mobile_for_file">
									
									<span v-if="info.image_mobile !== \'\'" class="input-group-text font-size-inherit">
										<a :href="\''.base_url('\'+info.image_mobile+\'').'\'" class="font-size-inherit text-decoration-none text-success" target="_blank">Preview</a>
									</span>
								</div>

								<input type="hidden" :name="\'image_key[\'+index+\']\'" :value="\'\'+index+\'\'">
								<input type="hidden" :name="\'image_id[\'+index+\'][id]\'" :value="\'\'+info.id+\'\'">

								<div class="row mb-4">
									<div class="col-12 mb-4">
										<h6 class="mb-0 pb-3 border-bottom">- Layout & Content Settings</h6>
									</div>

									<div class="col-md-6 mb-3 mb-md-0">
										<div class="row">
											<div class="col-12 mb-3">
												<label class="form-label">Display Cover Image</label>

												<select name="display_coverimage" class="form-select font-size-inherit" v-on:change="selectCoverImageType($event.target.value)"  aria-label="Select Display Type">
													<option value="">Select Display Type</option>
													<option value="only_image" '.$selected_display_type[0].'>Only With Image</option>
													<option value="background_image" '.$selected_display_type[1].'>With Background Image</option>
												</select>
											</div>

											<div class="col-md-6 mb-3">
												<label class="form-label">Image Size Desktop</label>

												<select name="image_size_desktop" class="form-select ph-form-select-size-desktop font-size-inherit" aria-label="Select Image Size Desktop" '.$disable_form_image_size_desktop.'>
													<option value="">Select Image Size Desktop</option>
													<option value="small" '.$image_size_desktop[0].'>Small</option>
													<option value="medium" '.$image_size_desktop[1].'>Medium</option>
													<option value="large" '.$image_size_desktop[2].'>Large</option>
													<option value="full" '.$image_size_desktop[3].'>Full Screen</option>
												</select>
											</div>

											<div class="col-md-6 mb-3">
												<label class="form-label">Image Size Mobile</label>

												<select name="image_size_mobile" class="form-select ph-form-select-size-mobile font-size-inherit" aria-label="Select Image Size Mobile" '.$disable_form_image_size_mobile.'>
													<option value="">Select Image Size Mobile</option>
													<option value="small" '.$image_size_mobile[0].'>Small</option>
													<option value="medium" '.$image_size_mobile[1].'>Medium</option>
													<option value="large" '.$image_size_mobile[2].'>Large</option>
													<option value="full" '.$image_size_mobile[3].'>Full Screen</option>
												</select>
											</div>

											<div class="col-md-6 mb-3">
												<label class="form-label">Parallax</label>

												<select name="is_parallax" class="form-select ph-form-select-is-parallax font-size-inherit" aria-label="Select Parallax" '.$disable_form_is_parallax.'>
													<option value="">Select Parallax</option>
													<option value="1" '.$is_parallax[1].'>Active</option>
													<option value="0" '.$is_parallax[0].'>Non Active</option>
												</select>
											</div>

											<div class="col-md-6">
												<label class="form-label">Adaptive Height</label>

												<select name="is_adaptive_height" class="form-select font-size-inherit" aria-label="Select Adaptive Height" disabled>
													<option value="">Select Adaptive Height</option>
													<option value="1" '.$is_adaptive_height[1].'>Active</option>
													<option value="0" '.$is_adaptive_height[0].'>Non Active</option>
												</select>
											</div>
										</div>
									</div>

									<div class="col-md-6 mb-4">
										<label class="form-label">Title</label>

										<div class="input-group mb-3">
											<input type="text" :name="\'image_text[\'+index+\'][title]\'" class="form-control font-size-inherit" :value="\'\'+info.title+\'\'">
										</div>

										<label class="form-label">Caption</label>

										<div class="input-group mb-3">
											<textarea :name="\'image_text[\'+index+\'][caption]\'" rows="5" class="form-control font-size-inherit">{{ info.caption }}</textarea>
										</div>
									</div>

									<div class="col-12 mb-4">
										<h6 class="mb-0 pb-3 border-bottom">- Button & Background Overlay Settings</h6>
									</div>

									<div class="col-md-6 mb-3">
										<div class="row">
											<div class="col-md-6 mb-3">
												<label class="form-label">Title Button 1</label>

												<input type="text" :name="\'image_button[\'+index+\'][0][title]\'" class="form-control font-size-inherit mb-3" placeholder="Title" v-model="info.get_var_button[0].title">
												
												<label class="form-label">Link Button 1</label>

												<input type="text" :name="\'image_button[\'+index+\'][0][content]\'" class="form-control font-size-inherit" placeholder="URL" v-model="info.get_var_button[0].content">
											</div>

											<div class="col-md-6 mb-3">
												<label class="form-label">Title Button 2</label>

												<input type="text" :name="\'image_button[\'+index+\'][1][title]\'" class="form-control font-size-inherit mb-3" placeholder="Title" v-model="info.get_var_button[1].title">
												
												<label class="form-label">Link Button 2</label>

												<input type="text" :name="\'image_button[\'+index+\'][1][content]\'" class="form-control font-size-inherit" placeholder="URL" v-model="info.get_var_button[1].content">
											</div>
										</div>
									</div>

									<div class="col-md-6 mb-3">
										<div class="row">
											<div class="col-md-6">
												<label class="form-label">Content Position Desktop</label>

												<select :name="\'image_style[\'+index+\'][position_desktop]\'" class="form-select font-size-inherit mb-3" v-model="info.get_var_style_position_desktop" aria-label="Select Content Position Desktop">
													<option value="">Select Position</option>
													<option value="left-top-desktop">Left Top</option>
													<option value="left-desktop">Left</option>
													<option value="left-w-text-center-desktop">Left with Text Center</option>
													<option value="left-w-text-right-desktop">Left with Text Right</option>
													<option value="left-bottom-desktop">Left Bottom</option>
													<option value="center-top-desktop">Center Top</option>
													<option value="center-desktop">Center</option>
													<option value="center-bottom-desktop">Center Bottom</option>
													<option value="right-top-desktop">Right Top</option>
													<option value="right-desktop">Right</option>
													<option value="right-w-text-left-desktop">Right with Text Left</option>
													<option value="right-w-text-center-desktop">Right with Text Center</option>
													<option value="right-bottom-desktop">Right Bottom</option>
												</select>
											</div>

											<div class="col-md-6">
												<label class="form-label">Content Position Mobile</label>

												<select :name="\'image_style[\'+index+\'][position_mobile]\'" class="form-select font-size-inherit mb-3" v-model="info.get_var_style_position_mobile" aria-label="Select Content Position Mobile">
													<option value="">Select Position</option>
													<option value="left-top-mobile">Left Top</option>
													<option value="left-mobile">Left</option>
													<option value="left-w-text-center-mobile">Left with Text Center</option>
													<option value="left-w-text-right-mobile">Left with Text Right</option>
													<option value="left-bottom-mobile">Left Bottom</option>
													<option value="center-top-mobile">Center Top</option>
													<option value="center-mobile">Center</option>
													<option value="center-bottom-mobile">Center Bottom</option>
													<option value="right-top-mobile-mobile">Right Top</option>
													<option value="right-mobile">Right</option>
													<option value="right-w-text-left-mobile">Right with Text Left</option>
													<option value="right-w-text-center-mobile">Right with Text Center</option>
													<option value="right-bottom-mobile">Right Bottom</option>
												</select>
											</div>
										</div>

										<label class="form-label">Background Overlay</label>

										<div class="input-group">
											<input type="text" :name="\'image_style[\'+index+\'][background_overlay]\'" class="form-control font-size-inherit" id="color-picker" v-model="info.get_var_style_background_overlay">
										</div>
									</div>
								</div>
							</div>
						</div>

						<div class="d-flex justify-content-end">
							<div>
								<input type="hidden" name="step" value="post">
								<input type="hidden" class="btn-token-submit" name="'.$csrf_name.'" value="'.$csrf_hash.'">
								<input type="submit" class="btn btn-malika-submit" value="'.t('Save').'">
							</div>
						</div>
					</div>			
				</form>
			</div>
		</div>
	</div>');


?>