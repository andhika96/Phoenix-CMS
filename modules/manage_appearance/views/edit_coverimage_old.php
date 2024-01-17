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
									<div class="col-md-6">
										<h6 class="mb-0 pb-3 border-bottom">- Image</h6>
									</div>

									<div class="col-md-6 text-md-end">
										<a href="javascript:void(0)" v-on:click="deleteForm(getListFormCoverimage, index, info.id); showData = !showData" class="text-danger text-underline ar-alert-bootbox font-size-inherit" v-bind:data-url="\''.site_url('manage_appearance/delete_coverimage/').'\'">Delete Image</a>
									</div>
								</div>

								<label class="form-label">For Web</label>								

								<div class="input-group mb-4">
									<input type="file" :name="\'image_web_\'+index+\'\'" class="form-control font-size-inherit" id="formFileImageWeb" aria-label="Form Image For Web" aria-describedby="button-addon2" v-model="info.image_web_for_file">
									
									<span v-if="info.id">
										<a :href="\''.base_url('\'+info.image_web+\'').'\'" class="input-group-text font-size-inherit" target="_blank">Preview</a>
									</span>
								</div>

								<label class="form-label">For Mobile</label>									

								<div class="input-group">
									<input type="file" :name="\'image_mobile_\'+index+\'\'" class="form-control font-size-inherit" id="formFileImageMobile" aria-label="Form Image For Mobile" aria-describedby="button-addon2" v-model="info.image_mobile_for_file">
									
									<input type="hidden" :name="\'image_key[\'+index+\']\'" :value="\'\'+index+\'\'">
									<input type="hidden" :name="\'image_id[\'+index+\'][id]\'" :value="\'\'+info.id+\'\'">
									
									<span v-if="info.id">
										<a :href="\''.base_url('\'+info.image_mobile+\'').'\'" class="input-group-text font-size-inherit" target="_blank">Preview</a>
									</span>
								</div>
							</div>

							<div class="row mb-4">
								<div class="col-12 mb-4">
									<h6 class="mb-0 pb-3 border-bottom">- Layout & Content Settings</h6>
								</div>

								<div class="col-12 mb-3">
									<label class="form-label">Content Title</label>
									<input type="text" name="content_title" class="form-control font-size-inherit" value="'.$row_layout['content_title'].'">
								</div>

								<div class="col-md-6">
									<div class="row">
										<div class="col-12 mb-3">
											<div class="row">
												<div class="col-md-6 mb-3">
													<label class="form-label">Display Cover Image</label>

													<select name="display_coverimage" class="form-select font-size-inherit" v-on:change="selectCoverImageType($event.target.value)"  aria-label="Select Display Type">
														<option value="">Select Display Type</option>
														<option value="only_image" '.$selected_display_coverimage[0].'>Only With Image</option>
														<option value="background_image" '.$selected_display_coverimage[1].'>With Background Image</option>
													</select>
												</div>

												<div class="col-md-6 mb-3">
													<label class="form-label">Select Size Cover Image</label>

													<select name="size_type" class="form-select ph-form-select-size font-size-inherit" aria-label="Select Size Cover Image">
														<option value="">Select Size</option>
														<option value="small" '.$size_type[0].'>Small (412px X 240px)</option>
														<option value="medium" '.$size_type[1].'>Medium (412px X 440px)</option>
														<option value="large" '.$size_type[2].'>Large (412px X 640px)</option>
														<option value="full" '.$size_type[3].'>Full Screen (412px X 840px)</option>
													</select>
												</div>
											</div>
										</div>

										<div class="col-12 mb-3">
											<div class="row">
												<div class="col-md-6">
													<label class="form-label">Select Parallax Effect</label>

													<select name="is_parallax" class="form-select font-size-inherit" aria-label="Select Parallax">
														<option value="">Select Parallax</option>
														<option value="1" '.$is_parallax[1].'>Active</option>
														<option value="0" '.$is_parallax[0].'>Non Active</option>
													</select>
												</div>

												<div class="col-md-6">
													<label class="form-label">Background Color Overlay</label>
													<input type="text" name="background_overlay" id="color-picker" class="form-control font-size-inherit" value="'.$row_layout['background_overlay'].'">
												</div>
											</div>
										</div>
									</div>
								</div>

								<div class="col-md-6">
									<label class="form-label">Content Description</label>
									<textarea name="content_description" class="form-control font-size-inherit" rows="5">'.$row_layout['content_description'].'</textarea>
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