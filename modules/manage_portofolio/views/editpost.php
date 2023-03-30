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

	section_content(breadcrumb([t('Manage Portofolio') => site_url('manage_portofolio'), t('Edit Post') => '']));

	$row['content'] = str_replace("&", "&amp;", $row['content']);

	$timezone  		= +7;
	$scheduled 		= ($row['schedule_pub'] !== 0) ? '<span class="badge bg-success">Scheduled for '.gmdate("M jS Y, g:i a", $row['schedule_pub']+$timezone*3600).'</span>' : '';
	$checked_box 	= ($row['schedule_pub'] !== 0) ? 'checked' : '';
	$value_box 		= ($row['schedule_pub'] !== 0) ? 1 : '';
	$active_form 	= ($row['schedule_pub'] !== 0) ? '' : 'disabled';
	$value_form 	= ($row['schedule_pub'] !== 0) ? gmdate("m/d/Y G:i", $row['schedule_pub']+$timezone*3600) : '';

	section_content('
	<!--- Custom CSS Daterange Picker --->
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css">

	<div class="container-fluid px-0" id="ar-app-form-article">
		<div class="arv6-box bg-white rounded shadow-sm" id="ar-form-submit">				
			<form action="'.site_url('manage_portofolio/editpost/'.$row['id']).'" method="post" enctype="multipart/form-data" @submit="submit" ref="formHTML" button-block="false" button-rounded-pill="false" font-size-large="false">
				<div class="p-4">
					<div class="h6 fw-bold pb-3 pb-md-4 mb-3 border-bottom"><i class="fad fa-edit fa-fw me-1"></i> Edit Post</div>
					<div class="toast ar-notice-toast position-relative bg-transparent align-items-center border-0" role="alert" aria-live="assertive" aria-atomic="true" data-bs-autohide="false"></div>

					<div class="row">
						<div class="col-md-6 mb-3">
							<label>Title</label>
							<input type="text" name="title" placeholder="Title here" class="form-control font-size-inherit" value="'.html_escape($row['title']).'">
						</div>

						<div class="col-md-6 mb-3">
							<label>Category</label>
							<select name="category" class="form-select font-size-inherit">
								<option value="">Select category</option>');

					$res_cat = $db->sql_select("select id, name from ml_portofolio_category order by id desc");
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

						<div class="col-md-6 mb-3 mb-md-0">
							<label class="form-label">Thumbnail</label>
							<input type="file" name="thumbnail" class="form-control font-size-inherit" id="customFile">
						</div>

						<div class="col-md-6">
							<label class="form-label">Schedule posts '.$scheduled.'</label>

							<div class="input-group mb-2">
								<div class="input-group-text pl-2 pr-1 py-0">
									<input type="checkbox" name="check_schedule_posts" class="form-check-input mt-0" value="'.$value_box.'" aria-label="activeSchedulePosts" v-on:click="activeSchedulePost" '.$checked_box.'>
								</div>

								<input type="text" name="schedule_pub" placeholder="Schedule posts" class="form-control form-control-schedule-posts font-size-inherit ar-schedule-pub2" value="'.$value_form.'" '.$active_form.'>
							</div>
						</div>
					</div>
				</div>

				<textarea class="form-control" id="editor" name="content" rows="12">'.$row['content'].'</textarea>

				<div class="d-flex justify-content-between p-4 text-right">
					<div class="mt-2" id="word-count"></div>

					<div>
						<input type="hidden" name="step" value="post">
						<input type="hidden" class="btn-token-submit" name="'.$csrf_name.'" value="'.$csrf_hash.'">
						<input type="submit" class="btn btn-bnight-blue btn-malika-submit" value="Submit">
					</div>
				</div>
			</form>
		</div>
	</div>');

?>