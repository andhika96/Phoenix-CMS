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

	section_content(breadcrumb([t('Manage Appearance') => '', t('Slideshow') => site_url('manage_appearance/slideshow'), t('Edit Slideshow') => '']));

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
					<i class="fad fa-images fa-fw me-2"></i> '.t('Edit Slideshow').'
				</div> 

				<div>
					<span class="float-md-right font-size-normal"><a href="javascript:void(0)" v-on:click="addFormSlideshow">New Form</a></span>
				</div>
			</div>

			<div id="ar-form-submit">
				<form action="'.site_url('manage_appearance/editslideshow/'.$uri).'" method="post" @submit="submit" button-block="false" font-size-large="false" button-rounded-pill="false" with-list-wopage="false" with-list-slideshow-page="true" with-list-coverimage-page="false" ref="formHTML">
					<div class="toast ar-notice-toast position-relative bg-transparent align-items-center border-0" role="alert" aria-live="assertive" aria-atomic="true" data-bs-autohide="false"></div>

					<div v-if="loadingSlideshowPage" class="text-center p-5">
						<div class="spinner-border text-primary mb-2" role="status">
							<span class="visually-hidden">Loading...</span>
						</div>

						<div class="h6">Loading ...</div>
					</div>

					<div v-else class="ar-data-load" style="display: none">

						<div class="row mb-4">
							<div class="col-12 mb-4">
								<h6 class="mb-0 pb-3 border-bottom">- Layout & Content Settings</h6>
							</div>

							<div class="col-md-4 mb-3">
								<label class="form-label">Display Slideshow</label>

								<select name="display_slideshow" class="form-select font-size-inherit" aria-label="Select Adaptive Height">
									<option value="">Select Effect</option>
									<option value="only_image" '.$selected_display_slideshow[0].'>Only With Image</option>
									<option value="background_image" '.$selected_display_slideshow[1].'>With Background Image</option>
								</select>
							</div>

							<div class="col-md-4 mb-3">
								<label class="form-label">Effect</label>

								<select name="effect" class="form-select font-size-inherit" aria-label="Select Adaptive Height">
									<option value="">Select Effect</option>
									<option value="fade" '.$selected_effect[0].'>Fade</option>
									<option value="nonfade" '.$selected_effect[1].'>Non Fade</option>
								</select>
							</div>

							<div class="col-md-4 mb-3">
								<label class="form-label">Autoplay</label>

								<select name="autoplay" class="form-select font-size-inherit" aria-label="Select Autoplay">
									<option value="">Select Autoplay</option>
									<option value="active" '.$selected_autoplay[0].'>Active</option>
									<option value="inactive" '.$selected_autoplay[1].'>Inactive</option>
								</select>
							</div>

							<div class="col-md-6 mb-3">
								<label class="form-label">Slide per View</label>

								<select name="slide_per_view" class="form-select font-size-inherit" aria-label="Select Slide per View">
									<option value="">Select Slide per View</option>
									<option value="1" '.$slide_per_view[0].'>1</option>
									<option value="2" '.$slide_per_view[1].'>2</option>
									<option value="3" '.$slide_per_view[2].'>3</option>
								</select>

								<i class="form-text">* If you set slide per view more than 1, fade effect cannot be use</i>
							</div>

							<div class="col-md-6 mb-3 mb-md-0">
								<label class="form-label">Autoplay Delay</label>

								<input type="text" name="autoplay_delay" class="form-control font-size-inherit" value="'.$row_layout['autoplay_delay'].'">
							</div>
						</div>

						<div class="row ar-fetch-listdata-slideshow" data-url="'.site_url('manage_appearance/getListSlideshow/'.$uri).'">
							<div class="col-12 mb-5" v-for="(info, index) in getListFormSlideshow" :key="index">
								<div class="row mb-2">
									<div class="col-md-6">
										<h6>- Image {{ index+1 }}</h6>
									</div>

									<div class="col-md-6 text-md-end">
										<a href="javascript:void(0)" v-on:click="deleteForm(getListFormSlideshow, index, info.id); showData = !showData" class="text-danger text-underline ar-alert-bootbox font-size-inherit" v-bind:data-url="\''.site_url('manage_appearance/deleteslideshow/').'\'">Delete Image</a>
									</div>
								</div>

								<div class="row">
									<div class="col-md-6 mb-3 mb-md-0">
										<label class="form-label">For Web (1440px X 720px)</label>								

										<div class="input-group mb-3">
											<input type="file" :name="\'image_web_\'+index+\'\'" class="form-control font-size-inherit" id="formFileImageWeb" aria-label="Form Image For Web" aria-describedby="button-addon2" v-model="info.image_web_for_file">
											
											<span v-if="info.id">
												<a :href="\''.base_url('\'+info.image_web+\'').'\'" class="input-group-text font-size-inherit" target="_blank">Preview</a>
											</span>
										</div>

										<label class="form-label">For Mobile (450px X 400px)</label>									

										<div class="input-group mb-3">
											<input type="file" :name="\'image_mobile_\'+index+\'\'" class="form-control font-size-inherit" id="formFileImageMobile" aria-label="Form Image For Mobile" aria-describedby="button-addon2" v-model="info.image_mobile_for_file">
											
											<span v-if="info.id">
												<a :href="\''.base_url('\'+info.image_mobile+\'').'\'" class="input-group-text font-size-inherit" target="_blank">Preview</a>
											</span>
										</div>

										<div class="row">
											<div class="col-md-6 mb-3">
												<label class="form-label">Button 1</label>

												<input type="text" :name="\'image_button[\'+index+\'][0][title]\'" class="form-control font-size-inherit mb-3" placeholder="Title" :value="\'\'+info.get_vars[\'button\'][0][\'title\']+\'\'">
												<input type="text" :name="\'image_button[\'+index+\'][0][content]\'" class="form-control font-size-inherit" placeholder="URL" :value="\'\'+info.get_vars[\'button\'][0][\'content\']+\'\'">
											</div>

											<div class="col-md-6 mb-3">
												<label class="form-label">Button 2</label>

												<input type="text" :name="\'image_button[\'+index+\'][1][title]\'" class="form-control font-size-inherit mb-3" placeholder="Title" :value="\'\'+info.get_vars[\'button\'][1][\'title\']+\'\'">
												<input type="text" :name="\'image_button[\'+index+\'][1][content]\'" class="form-control font-size-inherit" placeholder="URL" :value="\'\'+info.get_vars[\'button\'][1][\'content\']+\'\'">
											</div>
										</div>

										<label class="form-label">Content Position</label>

										<select :name="\'image_style[\'+index+\'][position]\'" class="form-select font-size-inherit mb-3" v-model="info.get_vars[\'style\'][\'position\']" aria-label="Select Content Position">
											<option value="">Select Position</option>
											<option value="left">Left</option>
											<option value="center">Center</option>
											<option value="right">Right</option>
										</select>
									</div>

									<div class="col-md-6">
										<label class="form-label">Title</label>

										<div class="input-group mb-3">
											<input type="text" :name="\'image_text[\'+index+\'][title]\'" class="form-control font-size-inherit" :value="\'\'+info.title+\'\'">
										</div>

										<label class="form-label">Caption</label>

										<div class="input-group mb-3">
											<textarea :name="\'image_text[\'+index+\'][caption]\'" rows="7" class="form-control font-size-inherit">{{ info.caption }}</textarea>
										</div>

										<label class="form-label">Background Overlay</label>

										<div class="input-group">
											<input type="text" :name="\'image_style[\'+index+\'][background_overlay]\'" class="form-control font-size-inherit color-picker" id="color-picker" :value="\'\'+info.get_vars[\'style\'][\'background_overlay\']+\'\'">
										</div>

										<input type="hidden" :name="\'image_key[\'+index+\']\'" :value="\'\'+index+\'\'">
										<input type="hidden" :name="\'image_id[\'+index+\'][id]\'" :value="\'\'+info.id+\'\'">
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