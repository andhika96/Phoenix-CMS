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

	section_content(breadcrumb([t('Manage Event') => site_url('manage_event'), t('List of Category') => site_url('manage_event/category'), t('Edit Category') => '']));

	section_content('
	<div class="container-fluid px-0" id="ar-app-listdata">
		<div class="arv6-box bg-white arv3-pc-content p-4 p-md-5 rounded shadow-sm" id="ar-form-submit">
			<div class="toast ar-notice-toast position-relative bg-transparent align-items-center border-0" role="alert" aria-live="assertive" aria-atomic="true" data-bs-autohide="false"></div>

			<form action="'.site_url('manage_event/editcategory/'.$id).'" method="post" @submit="submit" button-block="false" font-size-large="false" button-rounded-pill="false" with-list-wopage="true" ref="formHTML">
				<div class="row">
					<label class="col-md-3 col-form-label offset-md-1 pr-md-0 text-md-end">'.t('Category Name').'</label>
					
					<div class="col-md-5">
						<input type="text" name="category" class="form-control" value="'.$name.'">
					</div>

					<div class="col-md-4 offset-md-5 mt-2 text-end">
						<input type="hidden" name="step" value="post">
						<input type="hidden" class="btn-token-submit" name="'.$csrf_name.'" value="'.$csrf_hash.'">
						<input type="submit" class="btn btn-bnight-blue btn-malika-submit" value="'.t('Save').'">
					</div>
				</div>
			</form>
		</div>
	</div>');

?>