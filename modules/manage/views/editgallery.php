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

	section_content(breadcrumb(['Gallery' => site_url('manage/gallery'), 'Edit Category' => '']));

	section_content('
	<div class="container-fluid">
		<div class="bg-white arv3-pc-content p-4 p-md-5 rounded shadow-sm" id="ar-listdata-category">
			<div class="sk-notice-toast position-relative" aria-live="polite" aria-atomic="true"></div>

			<form action="'.site_url('manage/editgallery/'.$id).'" method="post" wbtn-block="1" data-reset="false" @submit="submit" ref="formHTML">
				<div class="row">
					<label class="col-md-3 col-form-label offset-md-1 pr-md-0 text-right">Category Name</label>
					
					<div class="col-md-5 mb-3">
						<input type="text" name="editcategory" class="form-control" value="'.$name.'">
					</div>

					<label class="col-md-3 col-form-label offset-md-1 pr-md-0 text-right">Caption</label>
					
					<div class="col-md-5">
						<textarea name="caption" rows="8" placeholder="Caption here" class="form-control">'.$caption.'</textarea>
					</div>

					<div class="col-md-4 offset-md-5 mt-2 text-right">
						<input type="hidden" name="step" value="post">
						<input type="hidden" class="btn-token" name="'.$csrf_name.'" value="'.$csrf_hash.'">
						<input type="submit" class="btn btn-bnight-blue" value="Save">
					</div>
				</div>
			</form>
		</div>
	</div>');

?>