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

	section_content(breadcrumb([t('Manage Promotion') => site_url('manage_promotion'), t('New Post') => '']));

	section_content('
	<!--- Custom CSS Daterange Picker --->
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css">

	<div class="container-fluid px-0" id="ar-app-form-article">
		<div class="arv6-box bg-white rounded shadow-sm" id="ar-form-submit">			
			<form action="'.site_url('manage_promotion/addpost').'" method="post" enctype="multipart/form-data" @submit="submit" ref="formHTML" button-block="false" button-rounded-pill="false" font-size-large="false">
				<div class="p-4">
					<div class="h6 fw-bold pb-3 pb-md-4 mb-3 border-bottom"><i class="fad fa-plus fa-fw mr-1"></i> New Post</div>
					<div class="toast ar-notice-toast position-relative bg-transparent align-items-center border-0" role="alert" aria-live="assertive" aria-atomic="true" data-bs-autohide="false"></div>

					<div class="row">
						<div class="col-md-6 mb-3">
							<label class="form-label">'.t('Title').'</label>
							<input type="text" name="title" placeholder="Title here" class="form-control font-size-inherit">
						</div>

						<div class="col-md-6 mb-3">
							<label class="form-label">'.t('Category').'</label>
							<select name="category" class="form-select font-size-inherit">
								<option value="">Select category</option>');

					$res = $db->sql_select("select id, name from ml_promotion_category order by id desc");
					while ($row = $db->sql_fetch_single($res))
					{
						section_content('
								<option value="'.$row['id'].'">'.$row['name'].'</option>');
					}

	section_content('
							</select>
						</div>

						<div class="col-md-4 mb-3 mb-md-0">
							<label class="form-label">'.t('Thumbnail').'</label>
							<input type="file" name="thumbnail" class="form-control font-size-inherit" id="customFile">
						</div>

						<div class="col-md-4 mb-3 mb-md-0">
							<label class="form-label">Status</label>
							<select name="status" class="form-select font-size-inherit">
								<option value="">Select status</option>
								<option value="0">Publish</option>
								<option value="1">Draft</option>
							</select>
						</div>

						<div class="col-md-4">
							<label class="form-label">'.t('Schedule Posts').'</label>

							<div class="input-group mb-3">
								<div class="input-group-text pl-2 pr-1 py-0">
									<input type="checkbox" name="check_schedule_posts" class="form-check-input mt-0" value="1" aria-label="activeSchedulePosts" v-on:click="activeSchedulePost">
								</div>

								<input type="text" name="schedule_pub" placeholder="Schedule posts" class="form-control form-control-schedule-posts font-size-inherit ar-schedule-pub" disabled>
							</div>
						</div>
					</div>
				</div>

				<textarea class="form-control" id="editor" name="content" rows="12"></textarea>

				<div class="d-flex justify-content-between p-4 text-right">
					<div class="mt-2" id="word-count"></div>

					<div>
						<input type="hidden" name="step" value="post">
						<input type="hidden" class="btn-token-submit" name="'.$csrf_name.'" value="'.$csrf_hash.'">
						<input type="submit" class="btn btn-bnight-blue btn-malika-submit font-size-inherit" value="'.t('Publish').'">
					</div>
				</div>
			</form>
		</div>
	</div>');

?>