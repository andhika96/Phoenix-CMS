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

	section_content(breadcrumb([t('Manage Promotion') => site_url('manage_promotion'), t('Edit Post') => '']));

	$row['content'] = str_replace("&", "&amp;", $row['content']);

	$timezone  		= +7;
	$scheduled 		= ($row['schedule_pub'] !== 0) ? '<span class="badge bg-success">Scheduled for '.gmdate("M jS Y, g:i a", $row['schedule_pub']+$timezone*3600).'</span>' : '';
	$checked_box 	= ($row['schedule_pub'] !== 0) ? 'checked' : '';
	$value_box 		= ($row['schedule_pub'] !== 0) ? 1 : '';
	$active_form 	= ($row['schedule_pub'] !== 0) ? '' : 'disabled';
	$value_form 	= ($row['schedule_pub'] !== 0) ? gmdate("m/d/Y G:i", $row['schedule_pub']+$timezone*3600) : '';

	$status_selected_0 	= ($row['status'] == 0) ? 'selected' : '';
	$status_selected_1 	= ($row['status'] == 1) ? 'selected' : '';

	section_content('
	<!--- Custom CSS Daterange Picker --->
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css">

	<div class="container-fluid px-0" id="ar-app-form-article">
		<ul class="nav nav-tabs mb-3" id="pills-tab" role="tablist">
			<li class="nav-item" role="presentation">
				<button class="nav-link active" id="main-tab" data-bs-toggle="tab" data-bs-target="#main-tab-pane" type="button" role="tab" aria-controls="home-tab" aria-selected="true">Main</button>
			</li>

			<li class="nav-item" role="presentation">
				<button class="nav-link" id="seo-tab" data-bs-toggle="tab" data-bs-target="#seo-tab-pane" type="button" role="tab" aria-controls="profile-tab" aria-selected="false">SEO</button>
			</li>
		</ul>

		<div class="tab-content" id="myTabContent">
			<div class="tab-pane fade show active" id="main-tab-pane" role="tabpanel" aria-labelledby="main-tab" tabindex="0">
				<div class="ar-fetch-detail-article" id="ar-form-submit" data-url="'.site_url('manage_promotion/getDetailPost/'.$row['id']).'">				
					<form action="'.site_url('manage_promotion/editpost/'.$row['id']).'" method="post" enctype="multipart/form-data" @submit="submit" ref="formHTML" button-block="false" button-rounded-pill="false" font-size-large="false">
						<div class="row">
							<div class="col-md-4 mb-4 mb-lg-0 order-lg-2">
								<div class="arv6-box bg-white rounded shadow-sm p-4">
									<div class="row">
										<div class="col-7 d-flex justify-content-end pe-0 mb-3">
											<a href="'.site_url('promotion/'.$row['uri']).'" class="btn btn-info font-size-inherit" target="_blank">Visit URL</a>
										</div>

										<div class="col-auto d-flex justify-content-end mb-3">
											<input type="hidden" name="step" value="post">
											<input type="hidden" class="btn-token-submit" name="'.$csrf_name.'" value="'.$csrf_hash.'">
											<input type="submit" class="btn btn-bnight-blue btn-malika-submit font-size-inherit" value="'.t('Save & Publish').'">
										</div>	

										<div class="col-12 mb-3">
											<label class="form-label">'.t('Category').'</label>
											<select name="category" class="form-select font-size-inherit">
												<option value="">Select category</option>');

									$res_cat = $db->sql_select("select id, name from ml_promotion_category order by id desc");
									while ($row_cat = $db->sql_fetch_single($res_cat))
									{
										if ($row['cid'] == $row_cat['id'])
										{
											section_content('
												<option value="'.$row_cat['id'].'" selected>'.$row_cat['name'].'</option>');
										}
										else
										{
											section_content('
												<option value="'.$row_cat['id'].'">'.$row_cat['name'].'</option>');
										}
									}

						section_content('
											</select>
										</div>

										<div class="col-12 mb-3">
											<label class="form-label">Status</label>
											<select name="status" class="form-select font-size-inherit">
												<option value="">Select status</option>
												<option value="0" '.$status_selected_0.'>Publish</option>
												<option value="1" '.$status_selected_1.'>Draft</option>
											</select>
										</div>

										<div class="col-12 mb-3">
											<label class="form-label">Schedule Post</label>

											<div class="input-group mb-2">
												<div class="input-group-text pl-2 pr-1 py-0">
													<input type="checkbox" name="check_schedule_posts" class="form-check-input mt-0" value="'.$value_box.'" aria-label="activeSchedulePosts" v-on:click="activeSchedulePost" '.$checked_box.'>
												</div>

												<input type="text" name="schedule_pub" placeholder="Schedule posts" class="form-control form-control-schedule-posts font-size-inherit ar-schedule-pub2" value="'.$value_form.'" '.$active_form.'>
											</div>

											<div>'.$scheduled.'</div>
										</div>

										<div class="col-12 mb-3">
											<label class="form-label">'.t('Thumbnail').'</label>
											<input type="file" name="thumbnail" class="form-control font-size-inherit" id="customFile" @change="previewImage($event)">

											<div class="mt-4 position-relative text-center d-flex align-items-center justify-content-center" style="width: auto;height: 250px;background-image: linear-gradient(45deg,#c3c4c7 25%,transparent 25%,transparent 75%,#c3c4c7 75%,#c3c4c7),linear-gradient(45deg,#c3c4c7 25%,transparent 25%,transparent 75%,#c3c4c7 75%,#c3c4c7);background-position: 0 0,10px 10px;background-size: 20px 20px;">
												<img :src="\'\'+imageEncode+\'\'" id="img-preview" class="img-fluid">
											</div>
										</div>
									</div>
								</div>
							</div>

							<div class="col-md-8">
								<div class="arv6-box bg-white rounded shadow-sm">
									<div class="p-4">
										<div class="h6 fw-bold pb-3 pb-md-4 mb-3 border-bottom"><i class="fad fa-edit fa-fw me-1"></i> Edit Post</div>
										<div class="toast ar-notice-toast position-relative bg-transparent align-items-center border-0" role="alert" aria-live="assertive" aria-atomic="true" data-bs-autohide="false"></div>

										<div class="row">
											<div class="col-md-6 mb-3">
												<label class="form-label">'.t('Title').'</label>
												<input type="text" name="title" placeholder="Title here" class="form-control font-size-inherit" value="'.html_escape($row['title']).'">
											</div>

											<div class="col-md-6 mb-3 mb-md-0">
												<label class="form-label">'.t('Slug').'</label>
												<input type="text" name="uri" placeholder="You can set slug here or leave it blank" class="form-control font-size-inherit" value="'.$row['uri'].'">
											</div>
										</div>
									</div>

									<textarea class="form-control" id="editor" name="content" rows="12">'.$row['content'].'</textarea>

									<div class="d-flex justify-content-start p-4 text-right">
										<div class="mt-2" id="word-count"></div>
									</div>
								</div>
							</div>
						</div>
					</form>
				</div>
			</div>

			<div class="tab-pane fade" id="seo-tab-pane" role="tabpanel" aria-labelledby="seo-tab" tabindex="0">
				<div class="ar-fetch-detail-metatag-article" id="ar-form-submit-seo" data-url="'.site_url('manage_promotion/getDetailMetatag/'.$row['id']).'">
					<form action="'.site_url('manage_promotion/setseo/'.$row['id'].'/from_edit_post').'" method="post" enctype="multipart/form-data" @submit="submitSEO" ref="formHTMLSEO" button-block="false" button-rounded-pill="false" font-size-large="false">
						<div class="toast ar-notice-toast-seo position-relative bg-transparent align-items-center border-0" role="alert" aria-live="assertive" aria-atomic="true" data-bs-autohide="false"></div>

						<div class="row">
							<div class="col-md-4 mb-4 mb-lg-0 order-lg-2">
								<div class="arv6-box bg-white rounded shadow-sm p-4">
									<div class="row">
										<div class="col-12 d-flex justify-content-end">
											<input type="hidden" name="step" value="post">
											<input type="hidden" class="btn-token-submit-seo" name="'.$csrf_name.'" value="'.$csrf_hash.'">
											<input type="submit" class="btn btn-malika-submit btn-malika-submit-seo font-size-inherit" value="'.t('Save & Publish').'">
										</div>
									</div>
								</div>
							</div>

							<div class="col-md-8">
								<div class="arv6-box bg-white rounded shadow-sm">
									<div class="p-4">
										<div class="h6 fw-bold pb-3 pb-md-4 mb-3 border-bottom"><i class="fad fa-brackets-curly fa-fw me-1"></i> SEO</div>
										<div class="toast ar-notice-toast position-relative bg-transparent align-items-center border-0" role="alert" aria-live="assertive" aria-atomic="true" data-bs-autohide="false"></div>

										<div class="row">
											<div class="col-12 mb-3">
												<label class="form-label">'.t('Meta Title').'</label>
												<input type="text" name="meta_title" placeholder="Meta title here" class="form-control font-size-inherit" value="'.$row_metatag['metatag_title'].'">
											</div>

											<div class="col-12 mb-3">
												<label class="form-label">'.t('Meta Description').'</label>
												<input type="text" name="meta_description" placeholder="Meta description here" class="form-control font-size-inherit" value="'.$row_metatag['metatag_description'].'">
											</div>

											<div class="col-md-6 mb-3">
												<label class="form-label">'.t('Meta Image').'</label>
												<input type="file" name="meta_image" class="form-control font-size-inherit" id="customFile" @change="previewMetaImage($event)">
											</div>

											<div class="col-md-6">
												<label class="form-label">'.t('Preview Image').'</label>
												
												<div class="position-relative text-center d-flex align-items-center justify-content-center" style="width: auto;height: 250px;background-image: linear-gradient(45deg,#c3c4c7 25%,transparent 25%,transparent 75%,#c3c4c7 75%,#c3c4c7),linear-gradient(45deg,#c3c4c7 25%,transparent 25%,transparent 75%,#c3c4c7 75%,#c3c4c7);background-position: 0 0,10px 10px;background-size: 20px 20px;">
													<img :src="\'\'+metaImageEncode+\'\'" id="meta-image-preview" class="img-fluid">
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>');

?>